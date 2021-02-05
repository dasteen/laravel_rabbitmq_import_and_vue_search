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
        serachValue: '',
        products: [],
        productsFound: 0,
        pagination: {
            page: 1,
            prevPage: null,
            nextPage: null,
        }
    },
    methods: {
        search: function (value = this.searchValue) {
            this.searchValue = value;
            fetch('/search?page='+ this.pagination.page +'&term=' + this.searchValue)
                .then(succesResponse => succesResponse.json())
                .then(result => {
                    if (result['data']) {
                        this.products = result.data;

                        this.productsFound = result.total

                        console.log(this.pagination.page > result.from, this.pagination.page, result.from)
                        this.pagination.prevPage = result.prev_page_url ? this.pagination.page - 1 : null;
                        this.pagination.nextPage = result.next_page_url ? this.pagination.page + 1 : null;
                    }
                });
        },
        toPage: function(page) {
            this.pagination.page = parseInt(page);
            this.search();
        }
    }
})
productsApp.search('');

let searchInput = document.querySelector('#searchInput');
searchInput.addEventListener('keyup', function (event) {
    let value = event.target.value;
    productsApp.search(value);
})
