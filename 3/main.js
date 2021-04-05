function Enlarge(id, show, img) {
  if (show == "1") {
    document.getElementById(id).style.visibility = "visible";
    document.getElementById(id).childNodes[1].src = img;
    
    const caption = img.slice(0, -4);
    document.getElementById(id).childNodes[3].textContent = caption;
  } else if (show == "0") {
    document.getElementById(id).style.visibility = "hidden";
  }
}
