const section = document.querySelector('.data');
const title = document.querySelector('.title');
const table = document.querySelector('.information');

let newHeight;

newHeight = title.clientHeight + table.clientHeight + 200;
section.setAttribute("style", `height: ${newHeight}px`);

console.log(newHeight);