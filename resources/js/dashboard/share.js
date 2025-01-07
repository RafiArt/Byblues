function copyToClipboard(element) {
    const url = element.getAttribute("data-url");
    const textarea = document.createElement("textarea");
    textarea.value = url;
    document.body.appendChild(textarea);
    textarea.select();
    document.execCommand("copy");
    document.body.removeChild(textarea);
    alert("Link copied to clipboard!");
}
