import Alpine from 'alpinejs'
import Intersect from '@alpinejs/intersect'

Alpine.plugin(Intersect)

Alpine.start()

window.Alpine = Alpine;


$(document).ready(function() {

    // DATABASE RSTORE
    $("a").click("restore_database", function(e) {
        if(e.target.id === "restore_database") {
            $("#database_file").trigger("click");
        }
    });

    $("input").change("database_file", function(e){
        if( e.target.id === "database_file" ) {
            $("#uploadForm").submit();
        }
    });



    // 
    $("button").click("[name=upload_excel]", function(e) {
        if(e.target.name === "upload_excel") {
            $(this).closest("form").find("input[name=excel_file]").trigger("click");
        }
    });

    $("input[name=excel_file]").change(function(e) {
        if(e.target.name === "excel_file") {
            $(this).closest("form").submit();
        }
    })

})