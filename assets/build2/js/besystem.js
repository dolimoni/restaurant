function updateSpendingGraph(data) {
    var enableLog=false;
    if(enableLog){
        console.log("Salaire---->", parseFloat(data["salary"]["salary"]));
        console.log("Produits---->", parseFloat(data["stock_history"]));
        console.log("Achats divers---->", parseFloat(data["purchase"]["price"]));
        console.log("Maintenance---->", parseFloat(data["repair"]["price"]));
    }
    var salary=0;
    var stock_history=0;
    var purchase=0;
    var repair=0;

    if(!isNaN(parseFloat(data["salary"]["salary"]))){
        salary= parseFloat(data["salary"]["salary"]);
    }

    if(!isNaN(parseFloat(data["stock_history"]))){
        stock_history= parseFloat(data["stock_history"]);
    }

    if(!isNaN(parseFloat(data["purchase"]["price"]))){
        purchase= parseFloat(data["purchase"]["price"]);
    }

    if(!isNaN(parseFloat(data["repair"]["price"]))){
        repair= parseFloat(data["repair"]["price"]);
    }
    if (enableLog) {
        console.log("Salaire---->", salary);
        console.log("Produits---->", stock_history);
        console.log("Achats divers---->", purchase);
        console.log("Maintenance---->", repair);
        console.log("heeeere");
    }
    var myDataPoints = [
        point = {
            y: salary,
            label: salary_lang,
            unit: 'DH'
        }, point = {
            y:stock_history,
            label: "Produits",
            unit: 'DH'
        }, point = {
            y: purchase,
            label: "Achats divers",
            unit: 'DH'
        }, point = {
            y: repair,
            label: "Maintenance",
            unit: 'DH'
        },
    ];
    var chart = new CanvasJS.Chart("spendingContainer", {
        animationEnabled: true,

        axisX:{
            tickColor: "red",
            tickLength: 5,
            tickThickness: 2
        },
        axisY:{
            tickLength: 15,
            tickColor: "DarkSlateBlue" ,
            tickThickness: 5
        },

        data: [{
            type: "doughnut",
            startAngle: 60,
            //innerRadius: 60,
            indexLabelFontSize: 17,
            indexLabel: "{label} - #percent%",
            toolTipContent: "<b>{label}:</b> {y}{unit} (#percent%)",
            dataPoints: myDataPoints
        }]
    });
    chart.render();
}

function update_global_data(data) {
    var consumption = data.report.consumption;
    var consumption_history = data.report.consumption_history;
    var purchaseObject = data.report.purchase;
    var repairObject = data.report.repair;
    var stock_historyObject = data.report.stock_history;
    var salaryObject = data.report.salary;

    var salary = 0;
    var stock_history = 0;
    var purchase = 0;
    var repair = 0;

    if (!isNaN(parseFloat(salaryObject["salary"]))) {
        salary = parseFloat(salaryObject["salary"]);
    }

    if (!isNaN(parseFloat(stock_historyObject))) {
        stock_history = parseFloat(stock_historyObject);
    }

    console.log("stock_history", parseFloat(stock_history));
    if (!isNaN(parseFloat(purchaseObject["price"]))) {
        purchase = parseFloat(purchaseObject["price"]);
    }

    if (!isNaN(parseFloat(repairObject["price"]))) {
        repair = parseFloat(repairObject["price"]);
    }

    var g_cost = parseFloat(salary + stock_history + purchase + repair).toFixed(2);
    var g_turnover = parseFloat(consumption["turnover"]).toFixed(2);
    if (isNaN(g_turnover)) {
        g_turnover = 0;
    }
    var g_quantity = parseFloat(consumption["s_quantity"]).toFixed(0);
    if (isNaN(g_quantity)) {
        g_quantity = 0;
    }
    $(".report_amount").html(g_turnover + " <small>DH</small>");
    $(".report_cost").html(g_cost + " <small>DH</small>");
    $(".report_profit").html(parseFloat(g_turnover - g_cost).toFixed(2) + " <small>DH</small>");
    $(".report_products").html(g_quantity);


    console.log(consumption_history.st_part + "!!!");
    $(".st_part").html(consumption_history.st_part);
    $(".nd_part").html(parseFloat(consumption_history.turnover - consumption_history.st_part).toFixed(2));
    $(".rd_part").html(consumption_history.rd_part);
}


//tabs

function tab(){
    var li = $('.r-tabs-nav .r-tabs-tab');
    li.on('click', function () {
        console.log(li);
        var link = $(this).find("a").attr('href');
        console.log(link);

        li.removeClass('r-tabs-state-active');
        li.addClass('r-tabs-state-default');
        $(this).addClass('r-tabs-state-active');

        var panel = $('div.r-tabs-panel');

        panel.removeClass('r-tabs-state-active');
        panel.addClass('r-tabs-state-default');
        panel.css({'display': 'none'});


        $(link).addClass('r-tabs-state-active');
        $(link).css({
            'display': 'block'
        })


    });
}

 function strPad(i, l, s) {
    var o = i.toString();
    if (!s) {
        s = '0';
    }
    while (o.length < l) {
        o = s + o;
    }
    return o;
};

function barCart(selector, labels, datasets, title,backgroundColor){
    var grapharea = document.getElementById(selector).getContext("2d");
    if(backgroundColor){
        datasets[0]["backgroundColor"] = backgroundColor;
    }else{
        var backgroundColor = ["#3e95cd", "#8e5ea2", "#3cba9f", "#e8c3b9", "#c45850"];
        datasets[0]["backgroundColor"] = backgroundColor;
    }

    var options={
        type: 'bar',
        data: {
            labels: labels,
            datasets: datasets
        },
        options: {
            legend: {display: false},
            responsive: true,
            title: title,
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            }
        }
    };

    var ctx = new Chart(grapharea, options);
    return ctx;

}

function convertDate(date,separator1,separator2,type){
    var response="";
    if(!date){
        return date;
    }
    switch(type) {
        case 1:
            //from dd-mm-yyyy to yyyy-mm-dd
            var datearray = date.split(separator1);
            response = datearray[2] + separator2 + datearray[1] + separator2 + datearray[0];
            break;
        case 2:
            //from yyyy-mm-dd to dd-mm-yyyy
            var datearray = date.split(separator1);
            response = datearray[0] + separator2 + datearray[1] + separator2 + datearray[2];
            break;
        case 3:
            //from yyyy-mm-dd to dd-mm-yyyy and remove time
            var datearrayTmp = date.split(" ");
            var datearray = datearrayTmp[0].split(separator1);
            response = datearray[2] + separator2 + datearray[1] + separator2 + datearray[0];
            break;
        default:

    }
    return response;
}

function getCurrentDate() {
    var d = new Date();

    var month = d.getMonth()+1;
    var day = d.getDate();

    var output = d.getFullYear() + '-' +
        (month<10 ? '0' : '') + month + '-' +
        (day<10 ? '0' : '') + day;

    return output;
}

function dateTimeToDate(dateTime) {
    var fullDate=new Date(dateTime);
    var twoDigitMonth = fullDate.getMonth() + "";
    if (twoDigitMonth.length == 1)
        twoDigitMonth = "0" + twoDigitMonth;
    var twoDigitDate = fullDate.getDate() + "";
    if (twoDigitDate.length == 1)
        twoDigitDate = "0" + twoDigitDate;
    var currentDate = twoDigitDate + "-" + twoDigitMonth + "-" + fullDate.getFullYear(); console.log(currentDate);

    return currentDate;
}

    function apiRequest(url,data,user_params,handleData){
    var response='';
    var params={
        'swal':'true',
        'callable':false,
        'reload':true,
        'callbackdata':null
    };
    if(user_params){
        params=user_params;
    }
    $.ajax({
        url: url,
        type: "POST",
        dataType: "json",
        data: data,
        beforeSend: function () {
            $('#loading').show();
        },
        complete: function () {
            $('#loading').hide();
        },
        success: function (data) {
            $('#loading').hide();
            if (data.status === "success") {
                if(params.swal==="true"){
                    swal({
                        title: "Success",
                        text: "Successs",
                        type: "success",
                        timer: 1500,
                        showConfirmButton: false
                    });
                }
                if(params.reload){
                    location.reload();
                }
            } else {
                swal({
                    title: "Erreur",
                    text: "Une erreur s'est produite",
                    type: "warning",
                    timer: 1500,
                    showConfirmButton: false
                });
            }
            if(params.callable){
                handleData(data,params.callbackdata);
            }
        },
        error: function (data) {
            swal({
                title: "Erreur",
                text: "Une erreur s'est produite",
                type: "warning",
                timer: 1500,
                showConfirmButton: false
            });
            if(params.callable){
                handleData(data);
            }
        }
    });
}

$(document).ready(function () {
    tab();
});
