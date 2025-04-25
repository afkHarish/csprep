const fs = require('fs');
const path = require('path');
const { exec } = require('child_process');
const { promisify } = require('util');
const execAsync = promisify(exec);

const executeHtml = async (filepath) => {
    try {
        // Read the HTML file
        const htmlContent = await fs.promises.readFile(filepath, 'utf-8');
        
        // For HTML, we'll return the content directly
        // The frontend will handle rendering it
        return {
            output: htmlContent,
            executionTime: 0,
            compileTime: 0
        };
    } catch (err) {
        throw new Error(`HTML execution error: ${err.message}`);
    }
};

module.exports = executeHtml; 