var SV = SV || {};

SV.Config = {};
SV.Config.debugMode = true;

function showError (title, msg) {
	alert (msg);
}

/**
 * Webservice call
 * <ul>
 * It assumes that:
 * <li>the webservice returns application/json;</li>
 * <li>the webservice returns a boolean "status" indicating success/error;</li>
 * <li>the webservice returns a string "message" describing the error cause or
 * simply a success message;</li>
 * </ul>
 * It uses the showError javascript function (make sure it is available).
 * <ul>
 * Public properties (usually set by the caller)
 * <li>context: (object) "this" object on callback functions</li>
 * <li>successFunction: (string) function to be called when service returns
 * successfully</li>
 * <li>failureFunction: (string) function to be called when service returns
 * with a failure</li>
 * <li>displayErrorMessage: (boolean) displays (or not) an error message after
 * the execution of the failureFunction</li>
 * <li>title: (string) title to be used on error messages</li>
 * </ul>
 * <ul>
 * Public properties (usually set by child classes)
 * <li>url: (string) webservice url</li>
 * <li>type: (string) webservice call method ('GET', 'POST')</li>
 * </ul>
 */
SV.Webservice = function() {

	// properties that are usually set by the caller
	this.params = {};
	this.context = null;
	this.successFunction = null;
	this.failureFunction = null;
	this.title = "";
	this.displayErrorMessage = true;
	this.displayBusyCursor = true;
	this.async = false;

	// properties that are usually set by child classes
	this.url = null;
	this.type = 'GET';
	this.dataType = '';
};

/**
 * Ajax call to webservice.
 */
SV.Webservice.prototype.callService = function() {

	if (!this.url) {
		// no service to call
		return;
	}

	var cfg = {};

	cfg.url = this.url;
	if (this.dataType == 'BODY') {
		cfg.data = JSON.stringify(this.params);
	} else {
		cfg.data = this.params;
	}
	cfg.type = this.type;
	cfg.async = this.async;
	cfg.context = this; // ajax return will run in service context

	cfg.success = function(result) {

		// busy cursor
		if (this.displayBusyCursor) {
			$('body').removeClass('svBusy');
		}

		try {
			if (result.status) {
				// user callback function
				if (this.successFunction) {
					// user callback function will run in user context
					if (this.context) {
						this.successFunction.call(this.context, result,
								this.params);
					} else {
						this.successFunction(result, this.params);
					}
				}
			} else {
				// prepare error message
				if (result.message) {
					var msg = result.message;
				} else {
					var msg = 'Error';
					if (SV.Config.debugMode) {
						msg += '\n' + JSON.stringify(result);
					}
				}

				// user callback function
				if (this.failureFunction) {
					// user callback function will run in user context
					if (this.context) {
						this.failureFunction.call(this.context, result,
								this.params, msg);
					} else {
						this.failureFunction(result, this.params, msg);
					}
				}

				// display error message
				if (this.displayErrorMessage) {
					showError(this.title, msg);
				}
			}
		} catch (err) {

			// prepare error message
			var msg = err.message;
			if (SV.Config.debugMode) {
				msg += '\n' + JSON.stringify(result);
			}

			// user callback function
			if (this.failureFunction) {
				// user callback function will run in user context
				if (this.context) {
					this.failureFunction.call(this.context, result,
							this.params, msg);
				} else {
					this.failureFunction(result, this.params, msg);
				}
			}

			// display error message
			if (this.displayErrorMessage) {
				showError(this.title, msg);

			}
		}
	};

	cfg.error = function(jqXHR, textStatus, errorThrown) {

		// busy cursor
		if (this.displayBusyCursor) {
			$('body').removeClass('svBusy');
		}

		// prepare error message
		var msg = 'Error';
		msg += '\n' + textStatus + ': ' + errorThrown;
		if (SV.Config.debugMode) {
			msg += '\n' + jqXHR.responseText;
		}

		// user callback function
		if (this.failureFunction) {
			// user callback function will run in user context
			if (this.context) {
				this.failureFunction.call(this.context, null, this.params, msg);
			} else {
				this.failureFunction(null, this.params, msg);
			}
		}

		// display error message
		if (this.displayErrorMessage) {
			showError(this.title, msg);
		}
	};

	if (this.displayBusyCursor) {
		$('body').addClass('svBusy');
		setTimeout(function() {
			$.ajax(cfg);
		}, 50);
	} else {
		$.ajax(cfg);
	}
	return false;
};

/**
 * Add a parameter to the webservice call.
 * 
 * @param name
 * @param value
 */
SV.Webservice.prototype.addParam = function(name, value) {
	this.params[name] = value;
};