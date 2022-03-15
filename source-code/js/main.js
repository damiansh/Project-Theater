//Base on a object with navigation data, it creates navigation elements
function navConstructor(liElement,navBar){
    for (element of liElement) {
        navElement = document.createElement("li");
        link = document.createElement("a");
        link.classList.add("nav-link");
        link.href=element.url;
        link.innerHTML=element.name;
        navElement.appendChild(link);
        navBar.appendChild(navElement);
      }
}


