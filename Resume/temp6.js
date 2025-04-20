let undoStack = [];

function saveState() {
    const contentClone = document.getElementById("content").cloneNode(true);
    undoStack.push(contentClone);
    if (undoStack.length > 10) undoStack.shift();
}

function undo() {
    if (undoStack.length > 0) {
        const previous = undoStack.pop();
        document.getElementById("content").replaceWith(previous);
        initializeEventListeners();
    }
}

document.getElementById("undoBtn").addEventListener("click", undo);

document.getElementById("headerColor").addEventListener("input", function (e) {
    document.querySelectorAll(".header").forEach(header => {
        header.style.backgroundColor = e.target.value;
    });
    saveState();
});

document.getElementById("lineColor").addEventListener("input", function (e) {
    document.querySelectorAll(".section h2").forEach(h2 => {
        h2.style.borderBottom = `2px solid ${e.target.value}`; /* Updated border width */
    });
    saveState();
});

function triggerImageUpload(event) {
    const inputId = event.target.nextElementSibling.id;
    document.getElementById(inputId).click();
}

document.querySelectorAll('input[type="file"]').forEach(input => {
    input.addEventListener("change", function () {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function (e) {
                const img = input.previousElementSibling;
                img.src = e.target.result;
                saveState();
            };
            reader.readAsDataURL(file);
        }
    });
});

document.getElementById("addHeader").addEventListener("click", function() {
    const newHeader = document.createElement("div");
    newHeader.classList.add("header", "editable");
    newHeader.innerHTML = `
        <div class="photo-container" onclick="triggerImageUpload(event)">
            <img id="newProfileImage" src="" alt="Profile"/>
            <input type="file" id="newImageUpload" accept="image/*" hidden/>
        </div>
        <div>
            <h1 contenteditable="true">Your Name</h1>
            <p contenteditable="true">Your Title</p>
        </div>
        <span class="delete-btn" onclick="removeSection(this.parentNode)">✖</span>
    `;
    document.querySelector(".page > .left-column").prepend(newHeader);
    initializeEventListeners();
    saveState();
});

function removeLine(btn) {
    const parent = btn.parentNode;
    if (parent.children.length > 1) {
        parent.removeChild(btn.previousElementSibling);
    } else if (parent.classList.contains('contact-section')) {
        parent.innerHTML = '<h2 contenteditable="true">CONTACT</h2><p contenteditable="true"></p><span class="delete-btn" onclick="removeLine(this)">✖</span>';
    } else if (parent.classList.contains('skills-section')) {
        parent.innerHTML = '<h2 contenteditable="true">RELEVANT SKILLS</h2><ul contenteditable="true"><li></li></ul><span class="delete-btn" onclick="removeLine(this)">✖</span>';
    } else if (parent.classList.contains('education-section')) {
        parent.innerHTML = '<h2 contenteditable="true">EDUCATION</h2><h3 contenteditable="true"></h3><p contenteditable="true"></p><span class="delete-btn" onclick="removeLine(this)">✖</span>';
    } else if (parent.classList.contains('experience-item')) {
        parent.parentNode.removeChild(parent);
    } else if (parent.classList.contains('section') && parent.children.length > 1) {
        parent.removeChild(parent.lastElementChild);
    }
    initializeEventListeners();
    saveState();
}

function removeSection(section) {
    section.remove();
    initializeEventListeners();
    saveState();
}

function addNewItem(sectionType, container) {
    let newItem;
    if (sectionType === 'experience') {
        newItem = document.createElement('div');
        newItem.classList.add('experience-item', 'editable');
        newItem.innerHTML = `
            <strong contenteditable="true">Job Title</strong>
            <small contenteditable="true">Company, Location (Start Date - End Date)</small>
            <ul contenteditable="true">
                <li>Responsibility 1</li>
                <li>Responsibility 2</li>
            </ul>
            <span class="delete-btn" onclick="removeLine(this.parentNode)">✖</span>
        `;
        container.appendChild(newItem);
    } else if (sectionType === 'skill') {
        const ul = container.querySelector('ul');
        const newLi = document.createElement('li');
        newLi.contentEditable = true;
        newLi.textContent = 'New Skill';
        ul.appendChild(newLi);
    } else if (sectionType === 'education') {
        newItem = document.createElement('div');
        newItem.classList.add('editable');
        newItem.innerHTML = `
            <h3 contenteditable="true">Degree Name</h3>
            <p contenteditable="true">Institution, Location (Year - Year)</p>
            <p contenteditable="true">Details</p>
            <span class="delete-btn" onclick="removeLine(this.parentNode)">✖</span>
        `;
        container.appendChild(newItem);
    } else if (sectionType === 'contact') {
        const newP = document.createElement('p');
        newP.contentEditable = true;
        newP.textContent = 'New Contact Info';
        container.appendChild(newP);
    } else if (sectionType === 'summary') {
        const newP = document.createElement('p');
        newP.contentEditable = true;
        newP.textContent = 'New summary point.';
        container.appendChild(newP);
    }
    initializeEventListeners();
    saveState();
}

function initializeEventListeners() {
    document.querySelectorAll('.editable[contenteditable="true"]').forEach(el => {
        el.addEventListener('input', saveState);
    });
    document.querySelectorAll('.photo-container').forEach(container => {
        container.onclick = triggerImageUpload;
    });
    document.querySelectorAll('input[type="file"]').forEach(input => {
        input.onchange = function () {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    const img = input.previousElementSibling;
                    img.src = e.target.result;
                    saveState();
                };
                reader.readAsDataURL(file);
            }
        };
    });
    document.querySelectorAll('.delete-btn').forEach(btn => {
        btn.onclick = function() {
            removeLine(this);
        };
    });
}

initializeEventListeners();
saveState();

function downloadResume() {
    window.print();
}