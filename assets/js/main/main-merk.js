require(["../common" ], function (common) {  
    require(["main-function","../app/app-merk"], function (func,application) { 
    App = $.extend(application,func);
        App.init();  
    }); 
});