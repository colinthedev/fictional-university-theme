import $ from 'jquery'

class Search {
	constructor() { // Describe and create our object 
		this.resultsDiv = $("#search-overlay__results");
		this.openButton = $(".js-search-trigger"); // Initialize anything in constructor first
		this.closeButton = $(".search-overlay__close");
		this.searchOverlay = $(".search-overlay");
		this.searchField = 	$('#search-term');
		this.typingTimer;
		this.isSpinnerVisible = false;
		this.previousSearchValue = '';
		this.events();
	}

	// Events
	events() {
		this.openButton.on('click', this.openOverlay.bind(this));
		this.closeButton.on('click', this.closeOverlay.bind(this));
		$(document).on('keyup', this.keyPressDispatcher.bind(this));
		this.searchField.on("keyup", this.typingLogic.bind(this));
	}

	// Methods (function, action)
	typingLogic() {
		if(this.searchField.val() != this.previousSearchValue) {
			clearTimeout(this.typingTimer);
			
			if(this.searchField.val()) {
				if(!this.isSpinnerVisible) {
					this.resultsDiv.html('<div class="spinner-loader"></div>');
					this.isSpinnerVisible = true;
				}
				this.typingTimer = setTimeout(this.getResults.bind(this), 2000);
			} else {
				this.resultsDiv.html('');
				this.isSpinnerVisible = false;
			}
		}

		this.previousSearchValue = this.searchField.val();
	}

	getResults() {
		$.getJSON('http://fictional-university.local/?search=biology', function() {
			
		});
	}

	keyPressDispatcher(e) {
		if(e.key === 's' && !$('input, textarea').is(':focus') ) {
			this.openOverlay();			
		}

		if(e.key === "Escape" ) {
			this.closeOverlay();
		}
	}

	openOverlay() {
		this.searchOverlay.addClass("search-overlay--active");
		$('body').addClass('body-no-scroll');
	}

	closeOverlay() {
		this.searchOverlay.removeClass("search-overlay--active");
		$('body').removeClass('body-no-scroll');
	}
}

export default Search