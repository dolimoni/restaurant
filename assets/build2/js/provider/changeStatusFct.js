$("#changeStatus").on('click','button',changeStatusEvent);
function changeStatusEvent(){
    var newStatus = $(this).attr("data-type");
    changeStatus("event",newStatus);
}

function changeStatus(type,newStatus) {
    if (type === "request" && (newStatus==="received" || newStatus==="answered"/*|| newStatus==="pending"*/|| newStatus==="canceled")) {
        $(".orderActualStatus").attr("data-toggle", null);
        $("#changeStatus").removeClass("in");
    } else {
        $(".orderActualStatus").attr("data-toggle", "collapse");
    }
    switch (newStatus) {
        case 'received':
            $('#changeStatus').empty();
            var b1 = '<button data-toggle="collapse" data-type="pending" href="#changeStatus" type="button" class="btn btn-round btn-info">' + pending_lang + '</button>';
            var b2 = '<button data-toggle="collapse" data-type="canceled" href="#changeStatus" type="button" class="btn btn-round btn-warning">' + canceled_lang + '</button>';
            $('#changeStatus').append(b1);
            $('#changeStatus').append(b2);
            $(".orderActualStatus").html(received_lang);
            $(".orderActualStatus").addClass("btn-success");
            $(".orderActualStatus").removeClass("btn-warning");
            $(".orderActualStatus").removeClass("btn-info");
            break;
        case 'canceled':
            $('#changeStatus').empty();
            var b1 = '<button data-toggle="collapse" data-type="received" href="#changeStatus" type="button" class="btn btn-round btn-success">' + received_lang + '</button>';
            var b2 = '<button data-toggle="collapse" data-type="pending" href="#changeStatus" type="button" class="btn btn-round btn-info">' + pending_lang + '</button>';
            $('#changeStatus').append(b1);
            $('#changeStatus').append(b2);
            $(".orderActualStatus").html(canceled_lang);
            $(".orderActualStatus").addClass("btn-warning");
            $(".orderActualStatus").removeClass("btn-info");
            $(".orderActualStatus").removeClass("btn-success");
            break;
        case 'pending':
            console.log("case 3");
            $('#changeStatus').empty();
            var b1 = '<button data-toggle="collapse" data-type="received" href="#changeStatus" type="button" class="btn btn-round btn-success">'+received_lang+'</button>';
            var b2 = '<button data-toggle="collapse" data-type="canceled" href="#changeStatus" type="button" class="btn btn-round btn-warning">'+canceled_lang+'</button>';
            $('#changeStatus').append(b1);
            $('#changeStatus').append(b2);
            $(".orderActualStatus").html(pending_lang);
            $(".orderActualStatus").addClass("btn-info");
            $(".orderActualStatus").removeClass("btn-warning");
            $(".orderActualStatus").removeClass("btn-success");
            break;
        case 'response_provider':
            console.log("case 3");
            $('#changeStatus').empty();
            var b1 = '<button data-toggle="collapse" data-type="accepted" href="#changeStatus" type="button" class="btn btn-round btn-success">Accepter</button>';
            var b2 = '<button data-toggle="collapse" data-type="canceled_stockitmain" href="#changeStatus" type="button" class="btn btn-round btn-warning">Annulée</button>';
            $('#changeStatus').append(b1);
            $('#changeStatus').append(b2);
            $(".orderActualStatus").html('Réponse fournisseur');
            $(".orderActualStatus").addClass("btn-info");
            $(".orderActualStatus").removeClass("btn-warning");
            $(".orderActualStatus").removeClass("btn-success");
            break;
        case 'accepted':
            console.log("case 3");
            $('#changeStatus').empty();
            var b1 = '<button data-toggle="collapse" data-type="response_provider" href="#changeStatus" type="button" class="btn btn-round btn-success">Réponse fournisseur</button>';
            var b2 = '<button data-toggle="collapse" data-type="canceled_stockitmain" href="#changeStatus" type="button" class="btn btn-round btn-warning">Annulée</button>';
            $('#changeStatus').append(b1);
            $('#changeStatus').append(b2);
            $(".orderActualStatus").html('Accepter');
            $(".orderActualStatus").addClass("btn-info");
            $(".orderActualStatus").removeClass("btn-warning");
            $(".orderActualStatus").removeClass("btn-success");
            break;
        case 'canceled_stockitmain':
            console.log("case 3");
            $('#changeStatus').empty();
            var b1 = '<button data-toggle="collapse" data-type="response_provider" href="#changeStatus" type="button" class="btn btn-round btn-success">Réponse fournisseur</button>';
            var b2 = '<button data-toggle="collapse" data-type="canceled_stockitmain" href="#changeStatus" type="button" class="btn btn-round btn-warning">Accepter</button>';
            $('#changeStatus').append(b1);
            $('#changeStatus').append(b2);
            $(".orderActualStatus").html('Annulée');
            $(".orderActualStatus").addClass("btn-info");
            $(".orderActualStatus").removeClass("btn-warning");
            $(".orderActualStatus").removeClass("btn-success");
            break;
        case 'answered':
            console.log("case 3");
            $('#changeStatus').empty();
            var b1 = '<button data-toggle="collapse" data-type="response_provider" href="#changeStatus" type="button" class="btn btn-round btn-success">Réponse fournisseur</button>';
            var b2 = '<button data-toggle="collapse" data-type="canceled_stockitmain" href="#changeStatus" type="button" class="btn btn-round btn-warning">Accepter</button>';
            $('#changeStatus').append(b1);
            $('#changeStatus').append(b2);
            $(".orderActualStatus").html('Répondu');
            $(".orderActualStatus").addClass("btn-info");
            $(".orderActualStatus").removeClass("btn-warning");
            $(".orderActualStatus").removeClass("btn-success");
            break;
        case 'wait_shipping':
            console.log("case 3");
            $('#changeStatus').empty();
            var b1 = '<button data-toggle="collapse" data-type="received_stockitmain" href="#changeStatus" type="button" class="btn btn-round btn-success">Reçue</button>';
            var b2 = '<button data-toggle="collapse" data-type="canceled_stockitmain_final" href="#changeStatus" type="button" class="btn btn-round btn-warning">Annulée</button>';
            $('#changeStatus').append(b1);
            $('#changeStatus').append(b2);
            $(".orderActualStatus").html('En attente de livraison');
            $(".orderActualStatus").addClass("btn-info");
            $(".orderActualStatus").removeClass("btn-warning");
            $(".orderActualStatus").removeClass("btn-success");
            break;
        case 'received_stockitmain':
            console.log("case 3");
            $('#changeStatus').empty();
            var b1 = '<button data-toggle="collapse" data-type="wait_shipping" href="#changeStatus" type="button" class="btn btn-round btn-success">En attente de livraison</button>';
            var b2 = '<button data-toggle="collapse" data-type="canceled_stockitmain_final" href="#changeStatus" type="button" class="btn btn-round btn-warning">Annulée</button>';
            $('#changeStatus').append(b1);
            $('#changeStatus').append(b2);
            $(".orderActualStatus").html('Reçue');
            $(".orderActualStatus").addClass("btn-info");
            $(".orderActualStatus").removeClass("btn-warning");
            $(".orderActualStatus").removeClass("btn-success");
            break;
        case 'canceled_stockitmain_final':
            console.log("case 3");
            $('#changeStatus').empty();
            var b1 = '<button data-toggle="collapse" data-type="wait_shipping" href="#changeStatus" type="button" class="btn btn-round btn-success">En attente de livraison</button>';
            var b2 = '<button data-toggle="collapse" data-type="received_stockitmain" href="#changeStatus" type="button" class="btn btn-round btn-warning">Reçue</button>';
            $('#changeStatus').append(b1);
            $('#changeStatus').append(b2);
            $(".orderActualStatus").html('Annulée');
            $(".orderActualStatus").addClass("btn-info");
            $(".orderActualStatus").removeClass("btn-warning");
            $(".orderActualStatus").removeClass("btn-success");
            break;
        default:
        //
    }

}
