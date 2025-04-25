const express = require("express");
const cors = require("cors");
const { generateFile } = require("./generateFile");
const executeHtml = require("./languages/executeHtml");
const executeJava = require("./languages/executeJava");
const executePython = require("./languages/executePython");
const executeC = require("./languages/executeC");
const executeCpp = require("./languages/executeCpp");
const { exec } = require('child_process');
const { promisify } = require('util');
const execAsync = promisify(exec);
const fs = require('fs');
const path = require('path');

const app = express();

// Add middleware
app.use(cors());
app.use(express.json());
app.use(express.urlencoded({ extended: true }));

// Add health check endpoint
app.get('/health', (req, res) => {
    res.json({
        status: 'ok',
        timestamp: new Date().toISOString(),
        environment: process.env.NODE_ENV || 'development'
    });
});

// Check Python environment
const checkPythonEnvironment = async () => {
    try {
        const { stdout, stderr } = await execAsync('python --version');
        return {
            python: stdout || stderr,
            success: true
        };
    } catch (error) {
        console.error('Python environment check failed:', error);
        return {
            success: false,
            error: error.message
        };
    }
};

// Add Python check endpoint
app.get('/check-python', async (req, res) => {
    const result = await checkPythonEnvironment();
    res.json(result);
});

// Ensure required directories exist
const codesPath = path.join(__dirname, 'codes');
const outputsPath = path.join(__dirname, 'outputs');

if (!fs.existsSync(codesPath)) {
    fs.mkdirSync(codesPath, { recursive: true });
    console.log('Created codes directory');
}

if (!fs.existsSync(outputsPath)) {
    fs.mkdirSync(outputsPath, { recursive: true });
    console.log('Created outputs directory');
}

// Add error handling middleware
app.use((err, req, res, next) => {
    console.error('Unhandled error:', err);
    res.status(500).json({
        success: false,
        error: err.message,
        details: err.stack
    });
});

// Add Java environment check function
const checkJavaEnvironment = async () => {
    try {
        const [javacVersion, javaVersion] = await Promise.all([
            execAsync('javac -version'),
            execAsync('java -version')
        ]);
        return {
            javac: javacVersion.stderr || javacVersion.stdout,
            java: javaVersion.stderr || javaVersion.stdout,
            success: true
        };
    } catch (error) {
        console.error('Java environment check failed:', error);
        return {
            success: false,
            error: error.message
        };
    }
};

// Add Java check endpoint
app.get('/check-java', async (req, res) => {
    const result = await checkJavaEnvironment();
    res.json(result);
});

app.get("/", (req, res) => {
    return res.json({ hello: "world!" });
});

app.post("/run", async (req, res) => {
    const { language = "cpp", code, input = "" } = req.body;

    console.log('Received run request:', {
        language,
        codeLength: code?.length,
        inputLength: input?.length
    });

    if (!code) {
        console.error('Empty code body received');
        return res.status(400).json({ success: false, error: "Empty code body!" });
    }

    try {
        // Check Python environment if running Python code
        if (language === "py") {
            const pythonCheck = await checkPythonEnvironment();
            if (!pythonCheck.success) {
                throw new Error(`Python environment check failed: ${pythonCheck.error}`);
            }
            console.log('Python environment check passed:', pythonCheck.python);
        }

        console.log("Generating file...");
        const filepath = await generateFile(language, code);
        console.log("File generated at:", filepath);
        
        let output;
        switch (language) {
            case "html":
                console.log("Executing HTML code...");
                output = await executeHtml(filepath);
                break;
            case "java":
                console.log("Executing Java code...");
                try {
                    output = await executeJava(filepath, input);
                    console.log("Java execution result:", output);
                } catch (javaError) {
                    console.error("Java execution failed:", {
                        error: javaError.message,
                        stack: javaError.stack
                    });
                    throw new Error(`Java execution failed: ${javaError.message}`);
                }
                break;
            case "py":
                console.log("Executing Python code...");
                try {
                    output = await executePython(filepath, input);
                    console.log("Python execution result:", output);
                    if (!output || (!output.output && !output.error)) {
                        throw new Error("No output received from Python execution");
                    }
                } catch (pyError) {
                    console.error("Python execution failed:", {
                        error: pyError.message,
                        stack: pyError.stack
                    });
                    throw new Error(`Python execution failed: ${pyError.message}`);
                }
                break;
            case "c":
                console.log("Executing C code...");
                try {
                    output = await executeC(filepath, input);
                    console.log("C execution result:", output);
                } catch (cError) {
                    console.error("C execution failed:", {
                        error: cError.message,
                        stack: cError.stack
                    });
                    throw new Error(`C execution failed: ${cError.message}`);
                }
                break;
            case "cpp":
                console.log("Executing C++ code...");
                try {
                    output = await executeCpp(filepath, input);
                    console.log("C++ execution result:", output);
                } catch (cppError) {
                    console.error("C++ execution failed:", {
                        error: cppError.message,
                        stack: cppError.stack
                    });
                    throw new Error(`C++ execution failed: ${cppError.message}`);
                }
                break;
            default:
                throw new Error(`Unsupported language: ${language}`);
        }

        // Ensure output is properly formatted
        if (!output) {
            output = { success: false, error: "No output received", output: "" };
        } else if (typeof output === 'string') {
            output = { success: true, output: output };
        }

        console.log("Execution successful, sending response:", output);
        return res.json({ 
            success: output.success !== false,
            filepath,
            ...output 
        });
    } catch (err) {
        console.error("Detailed execution error:", {
            message: err.message,
            stack: err.stack,
            code: err.code,
            language: language
        });
        return res.status(500).json({ 
            success: false, 
            error: err.message,
            details: err.stack
        });
    }
});

const PORT = process.env.PORT || 5001;

// Start server with error handling
app.listen(PORT, () => {
    console.log(`Server is running on port ${PORT}`);
    console.log(`Health check available at http://localhost:${PORT}/health`);
    console.log(`Python check available at http://localhost:${PORT}/check-python`);
}).on('error', (err) => {
    console.error('Server failed to start:', err);
    if (err.code === 'EADDRINUSE') {
        console.error(`Port ${PORT} is already in use. Please choose a different port or kill the process using this port.`);
    }
}); 