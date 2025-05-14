// DOM Elements
const input = document.getElementById('input');
const output = document.getElementById('output');
const runButton = document.getElementById('runCode');
const randomQuestionButton = document.getElementById('randomQuestion');
const timerDisplay = document.getElementById('timer');
const questionTitle = document.getElementById('questionTitle');
const questionDescription = document.getElementById('questionDescription');
const questionExample = document.getElementById('questionExample');
const languageSelect = document.getElementById('languageSelect');

// CodeMirror initialization
const editor = CodeMirror(document.getElementById('codeEditor'), {
    mode: 'python', // default mode
    theme: 'dracula',
    lineNumbers: true,
    autoCloseBrackets: true,
    matchBrackets: true,
    indentUnit: 4,
    tabSize: 4,
    indentWithTabs: false,
    lineWrapping: true,
    extraKeys: {
        'Tab': 'indentMore',
        'Shift-Tab': 'indentLess'
    }
});

// Language templates
const templates = {
    python: `# Your Python code here
def solve(input_data):
    # Write your solution here
    
    # Example: print("Hello World!")

# Get input and run solution
if __name__ == "__main__":
    input_data = input()  # Read input
    solve(input_data)`,
    
    java: `public class Main {
    public static void solve(String input) {
        // Write your solution here
        
        // Example: System.out.println("Hello World!");
    }
    
    public static void main(String[] args) {
        java.util.Scanner scanner = new java.util.Scanner(System.in);
        String input = scanner.nextLine();  // Read input
        solve(input);
    }
}`,
    
    c: `#include <stdio.h>
#include <stdlib.h>
#include <string.h>

void solve(char* input) {
    // Write your solution here
    
    // Example: printf("Hello World!\\n");
}

int main() {
    char input[1000];
    fgets(input, sizeof(input), stdin);  // Read input
    solve(input);
    return 0;
}`
};

// Current question ID
let currentQuestionId = null;

// Timer variables
let startTime = null;
let timerInterval = null;
let isTyping = false;

// Timer functions
function startTimer() {
    if (!startTime) {
        startTime = Date.now();
        updateTimer();
        timerInterval = setInterval(updateTimer, 1000);
    }
}

function stopTimer() {
    if (timerInterval) {
        clearInterval(timerInterval);
        timerInterval = null;
    }
}

function updateTimer() {
    const elapsedTime = Date.now() - startTime;
    const minutes = Math.floor(elapsedTime / 60000);
    const seconds = Math.floor((elapsedTime % 60000) / 1000);
    timerDisplay.textContent = `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
}

function resetTimer() {
    stopTimer();
    startTime = null;
    timerDisplay.textContent = '00:00';
}

// Code editor event listeners
editor.on('change', () => {
    if (!isTyping) {
        isTyping = true;
        startTimer();
    }
});

// Language change handler
languageSelect.addEventListener('change', () => {
    const language = languageSelect.value;
    if (editor.getValue() === '' || confirm('Changing the language will reset your code. Continue?')) {
        // Update CodeMirror mode
        switch (language) {
            case 'python':
                editor.setOption('mode', 'python');
                break;
            case 'java':
            case 'c':
                editor.setOption('mode', 'clike');
                break;
        }
        
        editor.setValue(templates[language]);
        resetTimer();
        isTyping = false;
    } else {
        languageSelect.value = previousLanguage;
    }
});

// Run code function
async function runCode() {
    runButton.disabled = true;
    output.textContent = 'Running...';

    const sourceCode = editor.getValue();
    const stdin = input.value;
    const language = languageSelect.value;

    // Map language to Judge0 language IDs
    const languageMap = {
        python: 71, // Python 3
        java: 62,   // Java
        c: 50       // C (gcc)
    };

    const languageId = languageMap[language];

    if (!languageId) {
        output.textContent = 'Error: Unsupported language';
        runButton.disabled = false;
        return;
    }

    try {
        // Create submission on Judge0 API
        const response = await fetch('https://judge0-ce.p.rapidapi.com/submissions?base64_encoded=false&wait=true', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-RapidAPI-Host': 'judge0-ce.p.rapidapi.com',
                'X-RapidAPI-Key': 'SIGN-UP-FOR-KEY' // Replace with your RapidAPI key
            },
            body: JSON.stringify({
                source_code: sourceCode,
                stdin: stdin,
                language_id: languageId
            })
        });

        if (!response.ok) {
            throw new Error(`API error: ${response.statusText}`);
        }

        const result = await response.json();

        if (result.stderr) {
            output.textContent = `Error: ${result.stderr}`;
            output.className = 'error-message';
        } else if (result.compile_output) {
            output.textContent = `Compile Error: ${result.compile_output}`;
            output.className = 'error-message';
        } else {
            output.textContent = result.stdout || 'No output';
            output.className = '';
        }
    } catch (error) {
        output.textContent = `Error: ${error.message}`;
        output.className = 'error-message';
    } finally {
        runButton.disabled = false;
        stopTimer();
    }
}

// Random question function
async function getRandomQuestion() {
    // Disable random question functionality as no backend questions API
    questionTitle.textContent = 'No questions available';
    questionDescription.textContent = '';
    questionExample.textContent = '';
    currentQuestionId = null;

    // Reset editor and timer
    const language = languageSelect.value;
    editor.setValue(templates[language]);
    input.value = '';
    output.textContent = '';
    output.className = '';
    resetTimer();
    isTyping = false;
}

// Event listeners
runButton.addEventListener('click', runCode);
randomQuestionButton.addEventListener('click', getRandomQuestion);

// Initialize with a random question and set initial template
let previousLanguage = languageSelect.value;
editor.setValue(templates[previousLanguage]);
getRandomQuestion(); 