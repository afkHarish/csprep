const fs = require('fs');
const path = require('path');
const { v4: uuidv4 } = require('uuid');

const generateFile = async (language, code) => {
    const jobId = uuidv4();
    const fileName = `${jobId}.${language}`;
    const filePath = path.join(__dirname, 'codes', fileName);
    
    try {
        // Ensure the codes directory exists
        const codesDir = path.join(__dirname, 'codes');
        if (!fs.existsSync(codesDir)) {
            fs.mkdirSync(codesDir, { recursive: true });
        }
        
        // Write the code to the file
        await fs.promises.writeFile(filePath, code);
        console.log(`File generated successfully at: ${filePath}`);
        return filePath;
    } catch (error) {
        console.error('Error generating file:', error);
        throw new Error(`Failed to generate file: ${error.message}`);
    }
};

module.exports = { generateFile };
