const fs = require('fs');
const path = require('path');
const { spawn } = require('child_process');

const TIMEOUT = 30000; // 30 seconds timeout

const executeJava = async (filepath, input = '') => {
    try {
        console.log('Java Execution Details:');
        console.log('Filepath:', filepath);
        console.log('Input:', input);

        return new Promise((resolve) => {
            let output = '';
            let error = '';
            let inputPrompt = '';
            let finalOutput = '';

            // Extract class name from filepath
            const className = path.basename(filepath, '.java');
            const classpath = path.dirname(filepath);

            // Compile Java code
            const compileProcess = spawn('javac', ['-d', classpath, filepath], {
                stdio: ['pipe', 'pipe', 'pipe'],
                shell: true,
                windowsHide: true
            });

            // Handle compilation output
            compileProcess.stderr.on('data', (data) => {
                const dataStr = data.toString();
                console.error('Compilation error:', dataStr);
                error += dataStr;
            });

            // Handle compilation completion
            compileProcess.on('close', (code) => {
                if (code !== 0) {
                    resolve({
                        success: false,
                        error: error,
                        output: ''
                    });
                    return;
                }

                // Execute Java program
                const execProcess = spawn('java', ['-cp', classpath, className], {
                    stdio: ['pipe', 'pipe', 'pipe'],
                    shell: true,
                    windowsHide: true
                });

                // Handle stdout
                execProcess.stdout.on('data', (data) => {
                    const dataStr = data.toString();
                    console.log('Received stdout:', dataStr);
                    
                    // Check if this is an input prompt
                    if (dataStr.includes(':')) {
                        inputPrompt = dataStr.trim();
                        console.log('Found input prompt:', inputPrompt);
                    } else {
                        finalOutput += dataStr;
                    }
                });

                // Handle stderr
                execProcess.stderr.on('data', (data) => {
                    const dataStr = data.toString();
                    console.error('Received stderr:', dataStr);
                    error += dataStr;
                });

                // Handle process exit
                execProcess.on('close', (code) => {
                    console.log('Process exited with code:', code);
                    
                    // Cleanup class file
                    try {
                        fs.unlinkSync(path.join(classpath, `${className}.class`));
                    } catch (err) {
                        console.error('Error cleaning up class file:', err);
                    }

                    resolve({
                        success: !error,
                        output: finalOutput.trim(),
                        error: error,
                        inputPrompt: inputPrompt
                    });
                });

                // Handle process error
                execProcess.on('error', (err) => {
                    console.error('Process error:', err);
                    resolve({
                        success: false,
                        error: err.message,
                        output: finalOutput.trim()
                    });
                });

                // If there's input, write it to stdin
                if (input) {
                    console.log('Writing input to stdin:', input);
                    execProcess.stdin.write(input + '\n');
                    execProcess.stdin.end();
                }

                // Set timeout
                const timeout = setTimeout(() => {
                    console.error('Process timed out');
                    execProcess.kill();
                    resolve({
                        success: false,
                        error: 'Execution timed out',
                        output: finalOutput.trim()
                    });
                }, TIMEOUT);

                // Clear timeout on process exit
                execProcess.on('exit', () => {
                    clearTimeout(timeout);
                });
            });
        });
    } catch (error) {
        console.error('Java Execution Error:', error);
        return {
            success: false,
            error: error.message,
            output: ''
        };
    }
};

module.exports = executeJava; 