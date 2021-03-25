/**
 * 
 * An input's type determines  what validation takes place. All inputs must be filled and not empty. Inputs of type text are tested against an alpha nuneric regex. Username inputs must be length > 2. Validation on the server will determine if username is taken. Inputs of type email are tested against and email regex and duplicate emails are checked on the server. Inputs of type password are tested against an alphanumeric regex with a few additional special characters allowed. 
 * 
 * Similar validation of all data processed in this class also takes place on the server.
 * 
 */

function Validator() { 
    
    this.success = false;
    this.errors = [];
    this.passFields = [];

    /**
     * If an array is given sets each input element's value to empty string else sets the singular input element's value to an empty string
     * @param {Array} elements - input element(s) that contains a value
     * @param {Number} num - 0 if the function must clear an array of inputs. 1 if only one input element needs clearing.
     */
    this.clearFields = (elements, num) => {
        switch(num){
            case 0:
                elements.forEach(element => {
                    element.value = "";
                });
                break;
            case 1:
                elements.value = "";
                break;
        }
    }
    /**
    * Removes a given css class from a given html element
    * 
    * @param {HTMLInputElement} element - HTML element whose cssClass variable needs clearing
    * @param {String} cssClass - the css class which needs to be removed.
    */
    this.clearPrevious = (element, cssClass) => { 
       if(element.classList.contains(cssClass)){
           element.classList.remove(cssClass);
       }
    }   

    /**
    *This function assumes, within the HTML markup, there is a HTML small element  directly after the supplied input element that can hold the error message. If the small element does not exist display a window alert holding the error message.
    *  
    * @param {HTMLInputElement}  element - html element that holds error message. 
    * @param {String} msg - the message that will be displayed
    */
    this.showError = (element, msg) => {
       this.clearPrevious(element, "form-valid");
       element.classList.add("form-error");
       if(element.nextElementSibling.tagName !== "SMALL"){
            alert(msg);
       }else{
            element.nextElementSibling.textContent = msg;
            element.nextElementSibling.classList.add("active");
       }
    }

    //Triggers valid field indicator
    this.showValid = (element) => {
       this.clearPrevious(element, "form-error");
       element.classList.add("form-valid");
       element.nextElementSibling.classList.remove("active");
    }

    /**
    * Checks if given element has a value or is empty, if not calls showError function with supplied error message.
    *
    * 
    * @param {HTMLInputElement} element - HTML input element
    * @param {String} msg - optional message that will be displayed
    * @return {boolean} - false if element is empty, true if element has a value
    */
    this.notEmpty = (element, msg = "") => { 
       if(element.value.trim() === ""){
           if(msg){
            this.showError(element, msg);
           }else{
             this.showError(element, "Enter " + element.getAttribute("name"));
           }
           return false;
       }else{
           this.showValid(element);
       }
       return true;
    }

    /**
    * Verifies the email contains allowed characters
    * 
    * @param {HTMLInputElement} element - html input element contianing email
    * 
    */
    this.checkEmail = (element) => {
       const emailRegex = /^[a-zA-Z0-9.!#$%&"*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)+$/;
       ////console.log(element.value.trim());
      
       this.success = emailRegex.test(element.value.trim());
       ////console.log("result of email pattern match " + element.getAttribute("id") + ": ", this.success);
       if(!this.success){
        this.showError(element, "Invalid email");
        this.clearFields(element, 1);
       } 
       return this.success;
    }
    /**
     * Verifies the password contains only alphanumeric and a few  allowed special characters.
     * 
     * @param {HTMLInputELement} element - HTML input element containing a password.
     * @param {Boolean} register - boolean determining whether registration or login is occurring
     * If login the confirm password field does not exist so no need to check.
     */
    this.checkPassword = (element, register) => {
        const passRegex = /^[a-z0-9!$:_#]+$/i;
        this.success = passRegex.test(element.value.trim());
        ////console.log("result of password pattern match " + element.getAttribute("id") + ": ", this.success);
        if(!this.success) { 
            this.showError(element, "Invalid password");
            this.clearFields(element, 1);
        }else if(register){ 
            ////console.log(this.passFields.length);
            // Password contains correct characters. Onward to verify both passwords are the same.
           if(this.passFields.length === 0){
               //store the first password in password array if array is empty
               this.passFields.push(element.value.trim());
           }else{
               //password array contains a value so compare it to current password
               ////console.log("passFields: ", this.passFields);
               if(this.passFields[0] !== element.value.trim()){
                   this.showError(element, "Passwords must match");
                   this.passFields = [];
                   this.clearFields(element, 1);
                   this.success = false;
               }
           }
        }
        return this.success;
    }

    /**
     * Verifies that first, last and username values contain only alpha numeric characters. This function expects the passed in element to have a name attribute whose value identifies whether it is a first name, last name, or username.
     * 
     * @param {HTMLInputElment} element - element containing either username, first name or last name
     * 
     * @returns {Boolean} this.success - true or false depending on if the input meets the regex specifications
     */
    this.checkText = (element) => {
        const nameRegex = /^[a-zA-z]+$/;
        const usernameRegex = /^[a-zA-Z0-9]{2,20}$/;
        const baseTextRegex = /^[a-zA-Z]+$/;
       
        switch(element.getAttribute("name")){
            case "firstName":
            case "lastName":
                
               this.success = nameRegex.test(element.value.trim());
               ////console.log("result of name pattern match with " + element.getAttribute("name") + ": ", this.success);                   
                if(!this.success){
                    this.showError(element, "Letters only");
                    this.clearFields(element, 1);
                } 
                return this.success;
            case "username":
                this.success = usernameRegex.test(element.value.trim());
                ////console.log("result of username pattern match " + element.getAttribute("name") + ": ", this.success);
                if(!this.success){
                    this.showError(element, "2 to 20 alpanumeric characters only.");
                    this.clearFields(element, 1);
                }
                return this.success;
            default:
                ////console.log("in the default case: ", element.getAttribute("name"));
                this.success = baseTextRegex.test(element.value.trim());
                ////console.log("result of base text patten match: " + this.success );
                if(!this.success){
                    this.showError(element, "Invalid characters"); 
                    this.clearFields(element, 1);
                } 
                return this.success;
        }
          
     
       
    }
    /**
     * Calls validation functions based on the input's type attribute
     * 
     * @param {HTMLInputElement} element - the input element by whose type is validated
     * @param {HTMLInputElement attribute} attrType - the type attribute of the input element 
     */
    this.typeValidation = (element, attrType, register) => {
       switch(attrType){
           case "text":
               this.success = this.checkText(element);
               ////console.log("Result of this input validation: " + this.success);
               break;
           case "email":
               this.success = this.checkEmail(element);
               break;
           case "password":
               this.success = this.checkPassword(element, register);
               break;
       }
       return this.success;
    }

}
/**
 * Calls validation functions for each of the supplied inputs fields
 * 
 * @param {Array} inputsArray - an array of input field values
 * @param {boolean} register - a boolean determining whether registration is occuring. If neither i.e. no password fields are present in form, default value is false
 */
Validator.prototype.check = function(inputsArray, register = false) {
    
    this.errors = [];
    //Checking if inputs are not empty
    inputsArray.forEach(input => {
        this.errors.push(this.notEmpty(input));
    });
    if(this.errors.indexOf(0) !== -1){ // A value is found meaning an error exists
       ////console.log("Form invalid");
       return false;
    }else{ 
        //If every element is not empty
        inputsArray.forEach(input =>{
            this.errors.push(this.typeValidation(input, input.getAttribute("type"), register));
        });
    }
    if(this.errors.includes(false)){
        ////console.log("Form invalid");
        return false;
    }
    ////console.log("The array of errors: " + this.errors)
    return true;
}
