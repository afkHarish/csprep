@echo off
start cmd /k "cd backend && npm install && node index.js"
start cmd /k "cd client && npm install && npm start" 