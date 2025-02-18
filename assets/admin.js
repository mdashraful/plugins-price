
       function addFeatureField() {
            let div = document.createElement("div");
            div.innerHTML = '<input type="text" name="features[]" required /> <button type="button" onclick="this.parentNode.remove()">Remove</button>';
            document.getElementById("feature-fields").appendChild(div);
        }
