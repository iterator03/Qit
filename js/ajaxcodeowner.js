/**
 * Created by root on 24/3/17.
 */
function refreshfeed() {
    console.log("Refreshing");
    $.ajax({
        type: "POST", 		//GET or POST or PUT or DELETE verb
        url: '../cronjob/listerqueue.php', 		// Location of the service
        data: {hashkey : $('#hashkey123').val()}, 		//Data sent to server
        dataType: "json", 	//Expected data format from server
        processdata: true, 	//True or False
    }).done(function (data) {
        $('#code_iterator').empty();
        console.log(data);
        $.each( data, function( key, value ) {
            var name_temp = value.name;
            var qid_temp = value.qid;
            var number = value.number;
            $('#code_iterator').prepend('<div class="alert alert-success"> For <strong> '+name_temp +'</strong><strong>Next Code: </strong> '+ qid_temp +'</div>');

        });
    });
}
$(document).ready(function () {
    setInterval(refreshfeed,3000);
});
