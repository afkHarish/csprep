const fs = require('fs');
const path = require('path');
const { spawn } = require('child_process');

const TIMEOUT = 30000; // 30 seconds timeout

const executePython = async (filepath, input = '') => {
    try {
        console.log('Python Execution Details:');
        console.log('Filepath:', filepath);
        console.log('Input:', input);

        return new Promise((resolve) => {
            let output = '';
            let error = '';
            let inputPrompt = '';
            let finalOutput = '';

            // Create a Python process
            const pythonProcess = spawn('python', [filepath], {
                stdio: ['pipe', 'pipe', 'pipe'],
                shell: true,
                windowsHide: true
            });

            // Handle stdout
            pythonProcess.stdout.on('data', (data) => {
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
            pythonProcess.stderr.on('data', (data) => {
                const dataStr = data.toString();
                console.error('Received stderr:', dataStr);
                error += dataStr;
            });

            // Handle process exit
            pythonProcess.on('close', (code) => {
                console.log('Process exited with code:', code);
                
                resolve({
                    success: !error,
                    output: finalOutput.trim(),
                    error: error,
                    inputPrompt: inputPrompt
                });
            });

            // Handle process error
            pythonProcess.on('error', (err) => {
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
                pythonProcess.stdin.write(input + '\n');
                pythonProcess.stdin.end();
            }

            // Set timeout
            const timeout = setTimeout(() => {
                console.error('Process timed out');
                pythonProcess.kill();
                resolve({
                    success: false,
                    error: 'Execution timed out',
                    output: finalOutput.trim()
                });
            }, TIMEOUT);

            // Clear timeout on process exit
            pythonProcess.on('exit', () => {
                clearTimeout(timeout);
            });
        });
    } catch (error) {
        console.error('Python Execution Error:', error);
        return {
            success: false,
            error: error.message,
            output: ''
        };
    }
};

module.exports = executePython; 