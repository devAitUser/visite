        new Vue({
    el: '#app_devis',
    vuetify: new Vuetify(),

    data() {

        return {
            dialog: false,
            expanded: [],
            singleExpand: true,
            pagination: {
                rowsPerPage: 5,

            },
            show_button_validation : true,
            btn_control: false,
            singleSelect: false,
            selectedRows: [],
            selected: [],
            search: '',
            sortBy: 'id',
            sortDesc: true,
            headers: [

                {
                    text: "Numero",
                    align: "left",
                    sortable: false,
                    value: "id"
                 },

                {
                    text: "Objet",
                    value: "objet"
                   },

                {
                    text: "Client",
                    align: "left",
                    sortable: false,
                    value: "client"
                },
                {
                    text: 'Visualiser le devis',
                    value: 'details'
                }

                



            ],

            devis: [

            ],
            editedIndex: -1,
            editedItem: {
                id: 0,
                client_id: 0,
                subtotal: 0,
                tva: 0,
                total: 0,
                typepaiement: '',
                statutpaiement: '',
            },
            defaultItem: {
                id: 0,
                client_id: 0,
                subtotal: 0,
                tva: 0,
                total: 0,
                typepaiement: '',
                statutpaiement: '',
            },
            product_order :[]

        }
    },


    methods: {

        show_order_product(item) {
           
             this.product_order =  item.product_order
            
            this.dialog = true
        },


        view_pdf(item) {
            
        
           window.open("devis_pdf/" + item.id, '_blank');
      
        },


        check_validation(item) {
            
           if(item.status == 2 ){
               return true
           } else {
               return false
           }
        },


        livre(item) {
          
            axios.post(window.laravel.url + '/livre/'+item.id)
                .then(response => {
                    if(response.data.etat){

                        location.reload();

                    }

                })
                .catch(error => {
                    console.log(error);
                })


        },

        clicked(value) {
            const index = this.expanded.indexOf(value)



            if (index === -1) {
                this.expanded.push(value)

            } else {
                this.expanded.splice(index, 1)
            }

        },

        get_status(id) {

            var status = "";

            var color = '';

            if(id == 1){
                status = "En cours"
                color = '#ff9800'; 
            }

            if(id == 2){
                status = "Validé par chef de projet"
                color = '#4caf50';
            }


            if(id == 3){
                status = "Refuser"
                color = '#f44336';
            }


            if(id == 4){
                status = "livré"
                color = '#286dd6';
            }


            var role_print = '<a style="background-color: ' + color + ';" class="badge badge-primary  p-2">' + status + '</a>';

            return role_print;
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

        }
        ,

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

                        axios.delete(window.laravel.url + '/deletedevis/' + this.selected[i].id)
                            .then(response => {
                                console.log(response);

                            })
                            .catch(error => {
                                console.log(error);
                            })

                        const index = this.devis.indexOf(this.selected[i]);


                        this.devis.splice(index, 1);
                    }
                    this.selected = [];




                    this.btn_control = false;

                    Swal.fire({

                            title: 'Supprimer!',
                            html: ' supprimer aver succes.',
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

        get_data: function() {

            axios.get(window.laravel.url + '/getdevis/')
                .then(response => {

                    console.log('this'+response.data.devis);

                    this.devis = response.data.devis;

              


                })
                .catch(error => {
                    console.log(error);
                })
        }
    },
    mounted: function() {

        this.get_data();



    }



})