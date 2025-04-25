const fs = require('fs');
const path = require('path');
const { spawn } = require('child_process');

const TIMEOUT = 30000; // 30 seconds timeout

const executeC = async (filepath, input = '') => {
    try {
        console.log('C Execution Details:');
        console.log('Filepath:', filepath);
        console.log('Input:', input);

        return new Promise((resolve) => {
            let output = '';
            let error = '';
            let inputPrompt = '';
            let finalOutput = '';

            // Create a C process
            const cProcess = spawn('gcc', [filepath, '-o', filepath.replace('.c', '.exe')], {
                stdio: ['pipe', 'pipe', 'pipe'],
                shell: true,
                windowsHide: true
            });

            // Handle compilation output
            cProcess.stderr.on('data', (data) => {
                const dataStr = data.toString();
                console.error('Compilation error:', dataStr);
                error += dataStr;
            });

            // Handle compilation completion
            cProcess.on('close', (code) => {
                if (code !== 0) {
                    resolve({
                        success: false,
                        error: error,
                        output: ''
                    });
                    return;
                }

                // Execute the compiled program
                const execProcess = spawn(filepath.replace('.c', '.exe'), [], {
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
                    
                    // Cleanup executable
                    try {
                        fs.unlinkSync(filepath.replace('.c', '.exe'));
                    } catch (err) {
                        console.error('Error cleaning up executable:', err);
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
        console.error('C Execution Error:', error);
        return {
            success: false,
            error: error.message,
            output: ''
        };
    }
};

module.exports = executeC; 