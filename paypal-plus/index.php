<?php
require_once('create_payment.php');
?>
<html>

<head>

    <link rel="stylesheet" href="styleppp.css">

</head>

<body>

    <section class="container wrap">


        <div class="item1">
            <div class="title">
                <b>
                    <p>Squier Telecaster Custom </p>
                </b>

            </div>

            <div class="img1">
                <img style="width:85%; max-width: 600px; max-height: 300px;" src="tele.jpg" alt="Telecaster">
            </div>

        </div>

        <div class="item2">

            <b>
                <p style="font-size: 1.5em;">$1500,00</p>
            </b>
            <p style="font-size: 0.9em;">Pay with your credit card</p>
            <p style=" font-size: 0.9em;color:blue">Up to 12 months</p>
            <i>
                <p style=" font-size: 0.7em; color:#4caf50">No interest</p>
            </i>
            <!-- <button type="submit" id="continueButton" onclick="ppp.doContinue(); return false;">
                Checkout
            </button> -->

        </div>


        <div class="item3">

            <div class="ppb">

                <div id="ppplusDiv"></div>


                <button class="ppbutton" type="submit" id="continueButton" onclick="ppp.doContinue(); return false;">
                    Pay
                </button>


            </div>
        </div>

    </section>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <script src="https://www.paypalobjects.com/webstatic/ppplusdcc/ppplusdcc.min.js" type="text/javascript"></script>




    <!-- obj -->

    <script type="application/javascript">
        let approvalUrl = document.getElementById('approval_url').innerText;
        var ppp = PAYPAL.apps.PPP({
            "approvalUrl": approvalUrl,
            "placeholder": "ppplusDiv",
            "mode": "sandbox",
            "payerFirstName": "Payer",
            "payerLastName": "Tester",
            "payerPhone": "956762315",
            "payerTaxId": "35666171801",
            "payerTaxIdType": "BR_CPF",
            "payerEmail": "payer@hotmail.com",
            "language": "pt_BR",
            "country": "BR",
            "rememberedCards": "customerRememberedCardHash",
        });
    </script>
    <!-- obj -->


    <!-- listener -->

    <script>
        if (window.addEventListener) {

            window.addEventListener("message", receiveMessage, false);

            console.log("addEventListener successful", "debug");

        } else if (window.attachEvent) {

            window.attachEvent("onmessage", receiveMessage);

            console.log("attachEvent successful", "debug");

        } else {

            console.log("Could not attach message listener", "debug");

            throw new Error("Can't attach message listener");

        }

        function receiveMessage(event) {

            try {

                var message = JSON.parse(event.data);

                if (typeof message['cause'] !== 'undefined') { //iFrame error handling

                    ppplusError = message['cause'].replace(/['"]+/g, ""); //log & attach this error into the order if possible

                    // <<Insert Code Here>>

                    switch (ppplusError)

                    {

                        case "INTERNAL_SERVICE_ERROR": //javascript fallthrough
                        case "SOCKET_HANG_UP": //javascript fallthrough
                        case "socket hang up": //javascript fallthrough
                        case "connect ECONNREFUSED": //javascript fallthrough
                        case "connect ETIMEDOUT": //javascript fallthrough
                        case "UNKNOWN_INTERNAL_ERROR": //javascript fallthrough
                        case "fiWalletLifecycle_unknown_error": //javascript fallthrough
                        case "Failed to decrypt term info": //javascript fallthrough
                        case "RESOURCE_NOT_FOUND": //javascript fallthrough
                        case "INTERNAL_SERVER_ERROR":
                            alert("Ocorreu um erro inesperado, por favor tente novamente. (" + ppplusError + ")"); //pt_BR
                            //Generic error, inform the customer to try again; generate a new approval_url and reload the iFrame.
                            // <<Insert Code Here>>
                            break;

                        case "RISK_N_DECLINE": //javascript fallthrough
                        case "NO_VALID_FUNDING_SOURCE_OR_RISK_REFUSED": //javascript fallthrough
                        case "TRY_ANOTHER_CARD": //javascript fallthrough
                        case "NO_VALID_FUNDING_INSTRUMENT":
                            alert("Seu pagamento não foi aprovado. Por favor utilize outro cartão, caso o problema persista entre em contato com o PayPal (0800-047-4482). (" + ppplusError + ")"); //pt_BR
                            //Risk denial, inform the customer to try again; generate a new approval_url and reload the iFrame.
                            // <<Insert Code Here>>
                            break;

                        case "CARD_ATTEMPT_INVALID":
                            alert("Ocorreu um erro inesperado, por favor tente novamente. (" + ppplusError + ")"); //pt_BR
                            //03 maximum payment attempts with error, inform the customer to try again; generate a new approval_url and reload the iFrame.
                            // <<Insert Code Here>>
                            break;

                        case "INVALID_OR_EXPIRED_TOKEN":
                            alert("A sua sessão expirou, por favor tente novamente. (" + ppplusError + ")"); //pt_BR
                            //User session is expired, inform the customer to try again; generate a new approval_url and reload the iFrame.
                            // <<Insert Code Here>>
                            break;

                        case "CHECK_ENTRY":
                            alert("Por favor revise os dados de Cartão de Crédito inseridos. (" + ppplusError + ")"); //pt_BR
                            //Missing or invalid credit card information, inform your customer to check the inputs.
                            // <<Insert Code Here>>
                            break;

                        default: //unknown error & reload payment flow
                            alert("Ocorreu um erro inesperado, por favor tente novamente. (" + ppplusError + ")"); //pt_BR
                            //Generic error, inform the customer to try again; generate a new approval_url and reload the iFrame.
                            // <<Insert Code Here>>

                    }

                }

                if (message['action'] == 'checkout') { //PPPlus session approved, do logic here

                    var rememberedCard = null;
                    var payerID = null;
                    var installmentsValue = null;

                    rememberedCard = message['result']['rememberedCards']; //save on user BD record
                    payerID = message['result']['payer']['payer_info']['payer_id']; //use it on executePayment API

                    console.log('######### message #########')
                    console.log(message)

                    if (message['result']['term']['term']) {
                        installmentsValue = message['result']['term']['term']; //installments value
                    } else {
                        installmentsValue = 1; //no installments
                    }

                    /* Next steps:

                    console.log (rememberedCard);
                    console.log (payerID);
                    console.log (installmentsValue);

                        1) Save the rememberedCard value on the user record on your Database.
                        2) Save the installmentsValue value into the order (Optional).
                        3) Call executePayment API using payerID value to capture the payment.

                    */

                    // <<Insert Code Here>>


                    let paymentID = document.getElementById('payment_id').innerText;

                    $.ajax({

                        url: "execute-payment.php",
                        type: "POST",
                        dataType: "json",
                        data: {
                            "payer_id": payerID,
                            "payment_id": paymentID
                        },
                    }).done(function(data, textStatus, jqxhr) {
                        // var myId = data.id;
                        // console.log("----------------------typeof(data)--------------------");
                        // console.log(typeof(data));
                        console.log(data);
                        console.log(textStatus);
                        console.log(jqxhr);
                        console.log("######## App.ExecutePayment.Done ########");
                        window.alert("Obrigada por comprar conosco");
                    }).fail(function(jqxhr, textStatus, errorThrown) {
                        console.log(jqxhr);
                        console.log(textStatus);
                        console.log(errorThrown);
                        console.log("######## App.ExecutePayment.Fail ########");
                        window.alert("Algo deu errado");
                    });

                }

            } catch (e) { //treat exceptions here

                // <<Insert Code Here>>
                console.log('####### Listener error #######');
                console.log(e)

            }

        }
    </script>
    <!-- listener -->
    <script>
        if (debug = true) {
            document.getElementById("payment_id").style.visibility = "hidden";
            document.getElementById("approval_url").style.visibility = "hidden";
            document.getElementById("execute_url").style.visibility = "hidden";

            // document.getElementsByClass("hideThisPlease").style.visibility = "hidden";
        }
    </script>





</body>

</html>