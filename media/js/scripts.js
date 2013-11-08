$(document).ready(function() {
	
	
	
	$("body.edit-action #menu li a").on('click', addCategory);
});

function addCategory(evt) {
	evt.preventDefault();
	$(this).attr("title", "Add this to the category list at right");
	var id = $(this).attr("data-id");
	var name = $(this).text();
	$remove = $("<a title='Remove' href=''>[X]</a>");
	$remove.on("click", removeCategory);
	console.log($remove);
	$newCat = $("<li>"
			+ "<input type='hidden' name='parents[]' value='" + id + "' />"
			+ name
			+ "</li>");
	$newCat.append($remove);
	$("ul#categories").append($newCat);
}

function removeCategory(evt) {
	evt.preventDefault();
	$(this).parent("li").remove();
}
