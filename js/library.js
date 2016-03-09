function warningModal(title,msg,continue_onclick,button_text){
	var modal = "<div id='warningModal' class='modal fade' role='dialog'>"
				+	"<div class='modal-dialog'>"
		
				+	"<div class='modal-content'>"
					+	"<div class='modal-header'>"
						+	"<button type='button' class='close' data-dismiss='modal'>&times;</button>"
							+	"<h4 class='modal-title'>" + title + "</h4>"
					+	"</div>"
					+	"<div class='modal-body'>"
						+	"<p>" + msg + "</p>"
					+	"</div>"
					+	"<div class='modal-footer'>"
						+	"<button type='button' class='btn btn-default pull-left' data-dismiss='modal'>Cancel</button>"
						+	"<button type='button' class='btn btn-default btn-warning' data-dismiss='modal' onclick=\"" + continue_onclick + "\">" + button_text + "</button>"
					+	"</div>"
				+	"</div>"
		
			+	"</div>"
		+	"</div>";
			
			$("body").append(modal);

			$('#warningModal').modal();
			
			$('#warningModal').on('hidden.bs.modal', function () {$('#warningModal').remove();});
}




function displayError(title, msg, href) {
	
	
      if ($('#errorDialog').length > 0) {
            $('#errorDialog').remove();
      }
      $("body").append(
                  $("<div style='display:none;' id='errorDialog'><p>" + htmlEncode(msg) + "</p></div>"));
      $('#errorDialog').prop('title', title);
      $('#errorDialog')
                  .dialog(
                              {
                                    modal : true,
                                    closeOnEscape : true,
                                    dialogClass : 'svErrorDialog',
                                    buttons : {
                                          Ok : function() {
                                                if (href != undefined) {
                                                      window.location.href = href;
                                                } else {
                                                      $(this).dialog("close");
                                                }
                                          }
                                    },
                                    open : function() {
                                          var closeBtn = $('.ui-dialog-titlebar-close');
                                          closeBtn
                                                      .addClass("ui-button ui-widget ui-state-default ui-corner-all ui-button-icon-only");
                                          closeBtn
                                                      .append('<span class="ui-button-icon-primary ui-icon ui-icon-closethick"></span><span class="ui-button-text" style="margin:0px; padding:0px;">close</span>');
                                          if (href != undefined) {
                                                closeBtn.click(function() {
                                                      window.location.href = href;
                                                });
                                          }
                                    }
                              });
      $('.ui-dialog .ui-dialog-buttonpane').css('border-width', '0px');
      // $('#errorDialog').find('.ui-dialog-buttonpane').css('border-width','0px');
}

function htmlEncode(value) {
    if (value) {
          var html = $('<div />').text(value).html();
          html = html.replace(/\n/g, "<br />");
          return html.replace(/\t/g, "&nbsp;&nbsp;&nbsp;&nbsp;");
    } else {
          return '';
    }
}
function htmlDecode(value) {
    if (value) {
          return $('<div />').html(value).text();
    } else {
          return '';
    }
}