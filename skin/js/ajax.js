var ajax = {
	method : 'get',
	url : " ",
	form : null,
	params : {},

	setForm:function(formId){
		this.form = $("#"+formId);
		return this;
	},
	resetForm:function(formId){
		this.form = null;
		return this;
	},

	getForm:function(){
		return this.form;
	},

	setMethod:function(method){
		this.method = method;
		return this;
	},

	getMethod:function(){
		return this.method;
	},

	setUrl:function(url){
		this.url = url;
		return this;
	},

	getUrl:function(){
		return this.url;
	},

	setParams:function(params){
		this.params = params;
		return this;
	},

	getParams:function(key=null){
		if (key === null) {
			return this.params;
		}

		if (this.params[key] === undefined) {
			return null;
		}
		return this.params[key];
	},

	prepareRequestSettings:function(){
		if (this.getForm()) {
			this.setParams(this.getForm().serializeArray());
			this.setMethod(this.getForm().attr('method'));
		}
	},

	resetRequestSettings:function(){
			this.setParams({});
			this.setMethod('get');
			this.resetForm();
			return this;
	},

	call:function(){
		let self = this;
		this.prepareRequestSettings();
		$.ajax({
			url:this.getUrl(),
			type:this.getMethod(),
			data:this.getParams(),
			dataType: "json"
		}).done(function(response){
			$('#'+response.element).html(response.html);
			if (response.messageBlockHtml !== undefined) {
				$('#message-html').html(response.messageBlockHtml);
			}
			ajax.resetRequestSettings();
		});
	}
};