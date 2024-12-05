    function addItemOnEnter(event) {
   if (event.keyCode === 13) {
      addItem();
   }
}
		function addItem() {
			var input = document.getElementById("myInput").value;
			var ul = document.getElementById("myList");
			var li = document.createElement("li");
			li.appendChild(document.createTextNode(input));
			ul.appendChild(li);
			document.getElementById("myInput").value = "";
		}

		function removeAll() {
			var ul = document.getElementById("myList");
			while (ul.firstChild) {
				ul.removeChild(ul.firstChild);
			}
		}
