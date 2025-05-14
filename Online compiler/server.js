const express = require('express');
const cors = require('cors');
const path = require('path');
const { exec } = require('child_process');
const tmp = require('tmp');
const fs = require('fs-extra');
const util = require('util');
const rateLimit = require('express-rate-limit');

const execPromise = util.promisify(exec);
const writeFilePromise = util.promisify(fs.writeFile);

const app = express();
const port = 3000;

// Rate limiting
const limiter = rateLimit({
    windowMs: 15 * 60 * 1000, // 15 minutes
    max: 100 // limit each IP to 100 requests per windowMs
});

app.use(cors());
app.use(express.json());
app.use(express.static('public'));
app.use(limiter);

// Sample programming questions with keywords
const programmingQuestions = [
    { 
        id: 1, 
        title: "Reverse a String", 
        description: "Write a function that reverses a string.", 
        example: "Input: 'hello' → Output: 'olleh'",
        keywords: ["reverse", "[::-1]", "reversed", "StringBuilder", "reverse()", "strrev"]
    },
    { 
        id: 2, 
        title: "Factorial", 
        description: "Write a function to calculate the factorial of a number.", 
        example: "Input: 5 → Output: 120",
        keywords: ["factorial", "fact", "multiply", "*=", "product"]
    },
    { 
        id: 3, 
        title: "FizzBuzz", 
        description: "Print numbers from 1 to n. For multiples of 3, print 'Fizz'. For multiples of 5, print 'Buzz'. For both, print 'FizzBuzz'.", 
        example: "n=15 → Output: 1,2,Fizz,4,Buzz,Fizz,7,8,Fizz,Buzz,11,Fizz,13,14,FizzBuzz",
        keywords: ["Fizz", "Buzz", "FizzBuzz", "divisible", "modulo", "%"]
    },
    { 
        id: 4, 
        title: "Find Maximum", 
        description: "Write a function to find the maximum number in an array.", 
        example: "Input: [1,4,2,7,3] → Output: 7",
        keywords: ["max", "maximum", "largest", "greater", ">"]
    },
    { 
        id: 5, 
        title: "Count Vowels", 
        description: "Write a function to count the number of vowels in a string.", 
        example: "Input: 'hello world' → Output: 3",
        keywords: ["vowel", "aeiou", "AEIOU", "count", "vowels"]
    },
    { 
        id: 6, 
        title: "Sum of Array", 
        description: "Write a function that returns the sum of all numbers in an array.", 
        example: "Input: [1,2,3,4,5] → Output: 15",
        keywords: ["sum", "total", "add", "+=", "accumulate"]
    },
    { 
        id: 7, 
        title: "Check Palindrome", 
        description: "Write a function to check if a string is a palindrome.", 
        example: "Input: 'racecar' → Output: true",
        keywords: ["palindrome", "reverse", "[::-1]", "equals", "same"]
    },
    { 
        id: 8, 
        title: "Count Words", 
        description: "Write a function to count the number of words in a string.", 
        example: "Input: 'Hello world!' → Output: 2",
        keywords: ["split", "words", "count", "space", "trim"]
    },
    { 
        id: 9, 
        title: "Find Even Numbers", 
        description: "Write a function to find all even numbers in an array.", 
        example: "Input: [1,2,3,4,5,6] → Output: [2,4,6]",
        keywords: ["even", "modulo", "%", "divisible", "2"]
    },
    { 
        id: 10, 
        title: "Calculate Power", 
        description: "Write a function to calculate the power of a number.", 
        example: "Input: base=2, exponent=3 → Output: 8",
        keywords: ["power", "pow", "exponent", "**", "multiply"]
    }
];

app.get('/questions', (req, res) => {
    res.json(programmingQuestions);
});

app.get('/random-question', (req, res) => {
    const randomIndex = Math.floor(Math.random() * programmingQuestions.length);
    res.json(programmingQuestions[randomIndex]);
});

function validateCode(code, questionId) {
    const question = programmingQuestions.find(q => q.id === questionId);
    if (!question) return false;

    return question.keywords.some(keyword => 
        code.toLowerCase().includes(keyword.toLowerCase())
    );
}

async function executePython(code, input) {
    const tmpFile = tmp.fileSync({ postfix: '.py' });
    const inputFile = tmp.fileSync();
    
    await writeFilePromise(tmpFile.name, code);
    if (input) {
        await writeFilePromise(inputFile.name, input);
    }

    try {
        const { stdout, stderr } = await execPromise(
            `python "${tmpFile.name}" < "${inputFile.name}"`,
            { timeout: 3000 }
        );
        return stderr ? `Error: ${stderr}` : stdout;
    } catch (error) {
        return `Error: ${error.message}`;
    } finally {
        tmpFile.removeCallback();
        inputFile.removeCallback();
    }
}

async function executeJava(code, input) {
    const tmpDir = tmp.dirSync();
    const className = 'Main';
    const javaFile = path.join(tmpDir.name, `${className}.java`);
    const inputFile = tmp.fileSync();

    await writeFilePromise(javaFile, code);
    if (input) {
        await writeFilePromise(inputFile.name, input);
    }

    try {
        await execPromise(`javac "${javaFile}"`, { timeout: 3000 });
        const { stdout, stderr } = await execPromise(
            `java -cp "${tmpDir.name}" ${className} < "${inputFile.name}"`,
            { timeout: 3000 }
        );
        return stderr ? `Error: ${stderr}` : stdout;
    } catch (error) {
        return `Error: ${error.message}`;
    } finally {
        fs.removeSync(tmpDir.name);
        inputFile.removeCallback();
    }
}

async function executeC(code, input) {
    const tmpDir = tmp.dirSync();
    const cFile = path.join(tmpDir.name, 'main.c');
    const exeFile = path.join(tmpDir.name, 'main.exe');
    const inputFile = tmp.fileSync();

    await writeFilePromise(cFile, code);
    if (input) {
        await writeFilePromise(inputFile.name, input);
    }

    try {
        await execPromise(`gcc "${cFile}" -o "${exeFile}"`, { timeout: 3000 });
        const { stdout, stderr } = await execPromise(
            `"${exeFile}" < "${inputFile.name}"`,
            { timeout: 3000 }
        );
        return stderr ? `Error: ${stderr}` : stdout;
    } catch (error) {
        return `Error: ${error.message}`;
    } finally {
        fs.removeSync(tmpDir.name);
        inputFile.removeCallback();
    }
}

app.post('/run', async (req, res) => {
    const { code, input, language, questionId } = req.body;
    
    // Validate code against question
    if (!validateCode(code, questionId)) {
        return res.json({
            success: false,
            error: "❌ Your code does not seem to match the current question. Please revise your solution."
        });
    }
    
    try {
        let output;
        switch (language) {
            case 'python':
                output = await executePython(code, input);
                break;
            case 'java':
                output = await executeJava(code, input);
                break;
            case 'c':
                output = await executeC(code, input);
                break;
            default:
                throw new Error('Unsupported language');
        }
        
        res.json({ 
            success: true,
            output: output
        });
    } catch (error) {
        res.json({ 
            success: false,
            error: error.message
        });
    }
});

app.listen(port, () => {
    console.log(`Server running at http://localhost:${port}`);
}); 