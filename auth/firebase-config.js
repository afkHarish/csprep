const firebaseConfig = {
    apiKey: "AIzaSyBrEnMz7LGZJYdjQDXSX_CuUjvA4aqQp4Q",
    authDomain: "csprep-d55a3.firebaseapp.com",
    projectId: "csprep-d55a3",
    storageBucket: "csprep-d55a3.firebasestorage.app",
    messagingSenderId: "189126536341",
    appId: "1:189126536341:web:9466ffa1885c2093287f9c",
    measurementId: "G-YM1REWXZ1K"
  };
// Initialize Firebase
firebase.initializeApp(firebaseConfig);

// Initialize Firebase services
const auth = firebase.auth();
const db = firebase.firestore(); 