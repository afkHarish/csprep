# Online Code Compiler

A simple online code compiler platform that allows users to write and execute JavaScript code, with features like a timer, random programming questions, and input/output support.

## Features

- JavaScript code execution in a sandboxed environment
- Input support for code that requires user input
- Timer that starts when typing begins
- Random programming questions for practice
- Modern and responsive UI
- Secure code execution using VM2

## Setup

1. Install dependencies:
```bash
npm install
```

2. Start the server:
```bash
npm start
```

3. Open your browser and navigate to:
```
http://localhost:3000
```

## Usage

1. Click the "Get Random Question" button to get a programming challenge
2. Write your JavaScript code in the code editor
3. If your code requires input, enter it in the input box (one value per line)
4. Click "Run Code" to execute your code
5. View the output in the output area
6. The timer will automatically start when you begin typing

## Security

- Code execution is sandboxed using VM2
- Execution time is limited to 3 seconds
- System commands are restricted
- Input is sanitized

## Technologies Used

- Frontend: HTML, CSS, JavaScript
- Backend: Node.js, Express
- Code Execution: VM2
- CORS enabled for local development 