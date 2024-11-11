document.getElementById('cta-button').addEventListener('click', function() {
    window.location.href = 'submit.html';
});

document.getElementById('messageForm').addEventListener('submit', function(event) {
    event.preventDefault();

    const recipient = event.target[0].value;
    const content = event.target[1].value;
    const color = event.target[2].value;

    const messageDisplay = document.createElement('div');
    messageDisplay.style.backgroundColor = color;
    messageDisplay.innerHTML = `<p>To ${recipient}: ${content}</p>
                                <p>Status: in love</p>
                                <button onclick="react()">❤️</button>
                                <button onclick="share()">Share</button>`;
    document.querySelector('.user-messages').appendChild(messageDisplay);
});

function react() {
    alert('You reacted with a heart!');
}

function share() {
    alert('Share options would go here.');
}
