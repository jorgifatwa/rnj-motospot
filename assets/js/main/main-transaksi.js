require(["../common" ], function (common) {  
    require(["main-function","../app/app-transaksi"], function (func,application) { 
    App = $.extend(application,func);
        App.init();  
    }); 
});