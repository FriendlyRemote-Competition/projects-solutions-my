const startColors = document.querySelector('#startColors');
const endColors = document.querySelector('#endColors');
const gradientBox = document.querySelector('#gradientBox');
const endColorInput = document.querySelector('#endColor');
const startColorInput = document.querySelector('#startColor');

let startColor = "#ff0000"
let endColor = "#0000ff"

for (let i = 0; i < 12; i++) {
    const div = document.createElement('div');
    div.classList.add('color-button');
    let color = `#${Math.floor(Math.random() * 16777215).toString(16).padStart(6, '0')}`
    div.style.backgroundColor = color

    let startNode = div.cloneNode(true);
    let endNode = div.cloneNode(true);

    startNode.addEventListener('click', () => setStartColor(color))
    endNode.addEventListener('click', () => setEndColor(color))

    startColors.appendChild(startNode);
    endColors.appendChild(endNode);
}
const setEndColor = color => {
    endColor = color;
    endColorInput.value = color;
    updateGradient()
}
const setStartColor = color => {
    startColor = color;
    startColorInput.value = color;
    updateGradient()
}

const updateGradient = () => {
    gradientBox.style.background = `linear-gradient(to right, ${startColor}, ${endColor})`
}

startColorInput.addEventListener('change', (e) => {
    startColor = e.target.value
    updateGradient()
})
endColorInput.addEventListener('change', (e) => {
    endColor = e.target.value
    updateGradient()
})