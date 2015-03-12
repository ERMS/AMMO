function changemonth() {
	var size = 31;
	var m = document.getElementById("month").value;
	var d = document.getElementById("day").value;
	var y = checkyear();
	if (m=="02"){
		if (y==1)
			size = 29;
		else
			size = 28;
	}
	else if (m=="04"||m=="06"||m=="09"||m=="11")
		size = 30;

	var string = "";
	var i, x;
	for (i=1; i<=size; i++ ) {
		if (i<10)
			x = "0" + i;
		else
			x = i;
		string = string + "<option value='" + x + "'";
		if (x==d)
			string = string + "selected";
		string = string + ">" + x + " </option>";
	}
	document.getElementById("day").innerHTML = string;
}
function checkyear() {
	var y = document.getElementById("year").value;
	if (y%400==0)
		return 1;
	else if (y%100==0) 
		return 0;
	else if (y%4==0) 
		return 1;
	else
		return 0;
}