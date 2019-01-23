
function validDate(mDate){
	var pattern=/^([a-zA-Z0-9]{4}(-[a-zA-Z0-9]{2}){2} [a-zA-Z0-9]{2}(:[a-zA-Z0-9]{2}){2})$/;
	//var pattern=/^(\d{2}/d{2}/d{4})$/;
	return mDate.match(pattern) !=null;
	
}

function validTextInput(mTextInput){
	var pattern =/^([a-zA-Z0-9]{4,63})$/;
	return mTextInput.match(pattern)!=null;
	
}

function validUsername(mUsername){
	var pattern =/^([a-zA-Z0-9]{6,63})$/;
	return mUsername.match(pattern)!=null;
	
}

function validPassword(mPassword){
	var pattern =/^([a-zA-Z0-9]{8,})$/;
	return mPassword.match(pattern)!=null;




}

function validEmail(mEmail){
	var pattern=/^([a-zA-Z0-9_.+]{2,}@[a-zA-Z0-9]{2,63}.[a-zA-Z0-9]{2,10})$/; 
	return mEmail.match(pattern)!=null; 
}