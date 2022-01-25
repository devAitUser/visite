new Vue({
    el: '#app_product_site',
    vuetify: new Vuetify(),

    data() {

        return {
            dialog: false,
            dialog1: false,
            expanded: [],
            qty : 0,
            
            edit_quantite : 0 ,
            singleExpand: true,
            pagination: {
                rowsPerPage: 5,

            },
            btn_control: false,
            singleSelect: false,
            selectedRows: [],
            selected: [],
            search: '',
            sortBy: 'id',
            sortDesc: true,
            filter: '',

            filters: {
                name: [],
                site: [],
        
                    },

            headers: [

                {
                    text: "Images",
                    align: "left",
                    sortable: false,
                    value: "img"
                },

                {
                    text: 'Designation',
                    value: 'designation'
                },
                {
                    text: ' Type',
                    value: 'type'
                },
                {
                    text: 'Quantite',
                    value: 'quantite'
                },
                {
                    text: 'Marque',
                    value: 'marque'
                },
                {
                    text: 'Prix',
                    value: 'prix'
                },

                {
                    text: 'Site',
                    value: 'site'
                },
                {
                    text: "Action",
                    value: "action",
                    sortable: false
                }



            ],

            products: [

            ],
            editedIndex: -1,
            editedItem: {
                id: 0,
                quantite: 0,
                designation: '',
                date_create: '',
            },
            defaultItem: {
                id: 0,
                quantite: 0,
                designation: '',
                date_create: '',
            },

        }
    },


    methods: {

        editItem(item) {
    
            this.editedItem.quantite = item.quantite

            this.qty = item.quantite

            this.editedIndex = this.products.indexOf(item)
            this.editedItem = Object.assign({}, item)
           
    
        },
        quantityCheck(value){
     
       
            if(value > 5){

                value = 5;

            } 
           
        },

        save() {

            if (this.editedIndex > -1) {

                var calcul = this.products[this.editedIndex].quantite - this.editedItem.quantite 

                this.editedItem["edit_quantite"] = this.editedItem.quantite
         
                this.editedItem.quantite = calcul



                Object.assign(this.products[this.editedIndex], this.editedItem)
           
                this.update_product_site(this.editedItem)

            } else {
                this.products.push(this.editedItem)
            }

            this.dialog.value = false

        },

        clicked(value) {
            const index = this.expanded.indexOf(value)



            if (index === -1) {
                this.expanded.push(value)

            } else {
                this.expanded.splice(index, 1)
            }

        },


        get_status(status_item) {

            console.log(status_item);

            var text = "";

            var color = '';

            if(status_item == 'Disponible'){
                text = "Disponible"
                color = 'badge-success'; 
            }

            if(status_item == 'Non Disponible'){
                text = "Non Disponible"
                color = 'badge-danger';
            }




            var status_print = '<span  class="badge badge-pill ' + color + '  p-2 m-1">' + text + '</span>';

            return status_print;
        },




        close() {

            this.dialog = false
            this.$nextTick(() => {
                this.editedItem = Object.assign({}, this.defaultItem)
                this.editedIndex = -1

            })
            this.expanded = [];

        },

        item: function(values) {

            if (values.length > 0) {

                this.btn_control = true;

            } else {
                this.btn_control = false;

            }


        },

        deleteItem() {

            Swal.fire({
                title: 'Êtes-vous sûr?',
                text: "voulez vous vraiment  supprimé",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText: 'Retour',
                confirmButtonText: 'Oui, Supprimé !'
            }).then((result) => {
                if (result.value) {

                    for (var i = 0; i < this.selected.length; i++) {

                        axios.delete(window.laravel.url + '/product/deleteproduct/' + this.selected[i].id)
                            .then(response => {

                            })
                            .catch(error => {
                                console.log(error);
                            })

                        const index = this.products.indexOf(this.selected[i]);


                        this.products.splice(index, 1);
                    }
                    this.selected = [];




                    this.btn_control = false;

                    Swal.fire({

                            title: 'Supprimer!',
                            html: 'Votre experience été supprimer aver succes.',
                            icon: 'success',
                            timer: 1000,
                            showConfirmButton: false,


                            onBeforeOpen: () => {

                                timerInterval = setInterval(() => {
                                    const content = Swal.getContent()
                                    if (content) {
                                        const b = content.querySelector('b')
                                        if (b) {
                                            b.textContent = Swal.getTimerLeft()
                                        }
                                    }
                                }, 100)
                            },
                            onClose: () => {
                                clearInterval(timerInterval)
                            }


                        }

                    )
                }
            })



        },
        update_product_site : function(item_object) {



            axios.post(window.laravel.url + '/updateproduct_site', item_object)
                .then(response => {
                    console.log(response.data);

                })
                .catch(error => {
                    console.log(error);
                })

        },
        remove_item() {

            if(this.btn_control){
                this.deleteItem();
            }
            else{

                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Au moins un élément doit être sélectionné!',
                  })

            }

        },
        customFilter(items, search, filter) {

            search = search.toString().toLowerCase()
            return items.filter(row => filter(row["type"], search));

        },
        columnValueList(val) {
            return this.products.map((d) => d[val]);
        },

        get_data: function() {
            axios.get(window.laravel.url + '/getproduct_site/')
                .then(response => {

                    this.products = response.data.products;
                    console.log(this.products );


                })
                .catch(error => {
                    console.log(error);
                })
        }
    },

    mounted: function() {


        

        this.get_data();



    },
    computed: {
        filteredDesserts() {
            return this.products.filter((d) => {
                return Object.keys(this.filters).every((f) => {
                    return this.filters[f].length < 1 || this.filters[f].includes(d[f]);
                });
            });
        },
    },
    
 



})