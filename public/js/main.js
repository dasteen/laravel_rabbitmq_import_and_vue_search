let importBtn = document.querySelector('#importBtn');

importBtn.addEventListener('click', function (event) {
    event.preventDefault();
    let url = event.target.getAttribute('href');
    fetch(url);
})

Vue.config.devtools = true
let productsApp = new Vue({
    el: '#vueApp',
    data: {
        products: [],
        productsFound: 0,
        pagination: {
            page: 1,
            prevPageLink: null,
            nextPageLink: null,
        }
    },
    methods: {
        search: function (value) {
            fetch('/search?page='+ this.pagination.page +'&term=' + value)
                .then(succesResponse => succesResponse.json())
                .then(result => {
                    if (result['data']) {
                        this.products = result.data;

                        this.productsFound = result.total

                        this.pagination.prevPageLink = result.prev_page_url;
                        this.pagination.nextPageLink = result.next_page_url;
                    }
                });
        }
    }
})


let searchInput = document.querySelector('#searchInput');

searchInput.addEventListener('keyup', function (event) {
    let value = event.target.value;
    productsApp.search(value);
})
