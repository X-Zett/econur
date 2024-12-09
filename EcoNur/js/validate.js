document.querySelector(".phone-input").addEventListener("keyup", function(){
    this.value = this.value.replace(/[^\d]/g, "");
});