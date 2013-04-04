
$(function() {   

 $("#UserLogin_addr").blur(function(){
$("#results").html("");

 var q=$("#UserLogin_addr").val();
    var url="http://geocode-maps.yandex.ru/1.x/?&geocode="+q+"&format=json&callback=?&key=APm-P08BAAAAFTTCUAIA1ITmjMUD6zV8cFJXLnIjvO-3Y80AAAAAAAAAAACmItDeXONoxzhlXL0WLHg2J9nQGQ==&results=9";
    
$.getJSON(url,function(data){
$.each(data.response.GeoObjectCollection.featureMember,function(key,val){

var lon=((val.GeoObject.Point.pos).split(' '))[0];
var lat=((val.GeoObject.Point.pos).split(' '))[1];
$("#results").append("<div class=result><input name=UserLogin[ll] type=radio class=ll value="+lat+";"+lon+">"+val.GeoObject.metaDataProperty.GeocoderMetaData.text+"</div><br>");
    });
    });
    

return false;

});

$(document).on("click", ".ll", function(){
if($("#ikway").length==0) {
$("#results").append("<input id='ikway' type='submit' value='ikway!'>");
}
});

});

