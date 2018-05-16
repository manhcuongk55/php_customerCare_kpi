var ALERT_INFO = 1;
var ALERT_WARNING = 2;
var ALERT_ERROR = 3;
var alertYesCallBackFunc = null;
var alertNoCallBackFunc = null;
$(document).ready(function() {
  $("#alert_ok_btn").click(function() {
    $("#modal_alert").modal("hide");
    if(alertYesCallBackFunc)
      alertYesCallBackFunc();
  });
  $("#alert_cancel_btn").click(function() {
    $("#modal_alert").modal("hide");
    if(alertNoCallBackFunc)
      alertNoCallBackFunc();
  });
});
function smartAlertDialog(title, content, type, yescallback, nocallback){
  var icon = "<i class='fa fa-info'></i>";
  if(type == ALERT_INFO){
    icon = "<i class='fa fa-info'></i>";
  }else if(type == ALERT_WARNING){
    icon = "<i class='fa fa-warning'></i>";
  }else if(type == ALERT_ERROR){
    icon = "<i class='fa fa-exclamation-circle'></i>";
  }
  $("#modal_alert_icon").html(icon);
  $("#modal_alert_title").html(title);
  $("#modal_alert_msg").html(content);

  alertYesCallBackFunc = yescallback;

  alertNoCallBackFunc = nocallback;

  $("#modal_alert").modal("show");

  // $("#dialog_alert_msg").html(content);
  // $('#dialog_alert').dialog({
  //   autoOpen : true,
  //   width : 500,
  //   resizable : true,
  //   modal : true,
  //   title : "<div class='widget-header'><h4>"+ icon +" "+title+"</h4></div>",
  //   buttons : [{
  //     html : "<i class='fa fa-check '></i>&nbsp; Yes",
  //     "class" : "btn btn-danger",
  //     click : function() {
  //       $(this).dialog("close");
  //       $(this).dialog("destroy");
  //       if(yescallback)
  //         yescallback();
  //     }
  //   }, {
  //     html : "<i class='fa fa-times'></i>&nbsp; Cancel",
  //     "class" : "btn btn-default",
  //     click : function() {
  //       $(this).dialog("close");
  //       $(this).dialog("destroy");
  //       if(nocallback)
  //         nocallback();
  //     }
  //   }]
  // });

  // $('#dialog_alert').dialog('open');
}

function smartConfirm(title, content, yescallback) {
  smartAlertDialog(title, content, ALERT_WARNING, yescallback, null);
}

function smartAlert(title, content, yescallback){
  smartAlertDialog(title, content, ALERT_WARNING, yescallback, null);
}

// function smartAlert(title, content){
//   smartAlertDialog(title, content, ALERT_WARNING, null, null);
// }

function smartInfo(title, content, yescallback){
  smartAlertDialog(title, content, ALERT_INFO, yescallback, null);
}

// function smartInfo(title, content){
//   smartAlertDialog(title, content, ALERT_INFO, null, null);
// }

function smartError(title, content, yescallback){
  smartAlertDialog(title, content, ALERT_ERROR, yescallback, null);
}

// function smartError(title, content){
//   smartAlertDialog(title, content, ALERT_ERROR, null, null);
// }


function smartMessage(title, content, type, showtime, _icon){
  var color = "#3276B1";
  var icon = "fa-info";
  switch (type) {
    case ALERT_WARNING:
      color = "#C79121";
      icon = "fa-warning";
      break;
    case ALERT_ERROR:
      color = "#C46A69";
      icon = "fa-exclamation-circle"
      break;
    default:
      color = "#3276B1";
      icon = "fa-info";
      break;
  }
  if (_icon)
    icon = _icon;

  if(showtime > 0){
    $.smallBox({
      title : title,
      content : content,
      color : color,
      timeout: showtime,
      icon : "fa " + icon
    });
  }else{
    $.smallBox({
      title : title,
      content : content,
      color : color,
    //  timeout: showtime,
      icon : "fa " + icon
    });
  }
}

// function smartWarningMsg(title, content){
//   smartMessage(title, content, ALERT_WARNING, 0);
// }

function smartWarningMsg(title, content, showtime, icon){
  smartMessage(title, content, ALERT_WARNING, showtime, icon);
}

function smartInfoMsg(title, content, showtime, icon){
  smartMessage(title, content, ALERT_INFO, showtime, icon);
}
// function smartInfoMsg(title, content){
//   smartMessage(title, content, ALERT_INFO, 0);
// }

function smartErrorMsg(title, content, showtime, icon){
  smartMessage(title, content, ALERT_ERROR, showtime, icon);
}

// function smartErrorMsg(title, content){
//   smartMessage(title, content, ALERT_ERROR, 0);
// }
