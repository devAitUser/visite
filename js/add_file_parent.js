



new Vue({
    el: '#app_folder',
    vuetify: new Vuetify(),

    data: () => ({
        dialog: false,
        name_folder: '',
        id_item: '',
        nextId: 0,
        checked: 'folder',

        open: ['public'],

        files: {
            html: 'mdi-language-html5',
            js: 'mdi-nodejs',
            json: 'mdi-json',
            md: 'mdi-markdown',
            pdf: 'mdi-file-pdf',
            png: 'mdi-file-image',
            txt: 'mdi-file-document-outline',
            xls: 'mdi-file-excel'
        },
        sortBy: 'id',
        sortDesc: true,

        reponse_items: [],

        headers: [

            {
                text: 'Id',
                align: 'start',
                sortable: false,
                value: 'id',
            },

            {
                text: 'parentId',
                value: 'parentId'
            },
            {
                text: 'Nom de Fichier ou Dossier',
                value: 'name'
            },

            {
                text: 'Extension',
                value: 'file'
            },
            {
                text: "Action",
                value: "action",
                sortable: false
            }

        ],
        folder: {
            name_item: '',
            id_item: null,
            file: [],
        },
        array_item: [],
        tree: [],
        switch2: false,
        show_input_file: false,
        show_text_folder: true,
        items_label: [],
        items: [],
        tab: null,
        item_tabs: [
            'Assigner', 'tab2', 'tab3',
        ],
        item_fields: [
            'Nom', 'Date', 'Anne',
        ],
        select_item: null,
        editedItem: {
            id: '',
            name: '',
            file: ''
        },
        defaultItem: {
            id: '',
            name: '',
            file: ''
        },
        editedIndex: -1,

    }),

    computed: {
        allChecked: {
            get() {
                return this.checkList.every(Boolean);
            },
            set(isChecked) {
                for (let index = 0; index < this.checkList.length; index++) {
                    this.$set(this.checkList, index, isChecked);
                }
            }
        },
        indeterminate() {
            return !this.allChecked && this.checkList.some(Boolean);
        }
    },



    methods: {



        buscaBlob(item) {
            axios.get(`https://localhost:44392/api/Files/GetSpecific/5?blobName=PDF TESTE.pdf`)
                .then(response => {
                    item.comCheckout = 1
                    // this.editedItem.urlAnexo = response.data.uri
                    let file = response.data
                    let docfile = new File([file], `${file.name}`)
                    // const objectURL = window.URL.createObjectURL(file);
                    let link = document.createElement('a')
                    // link.href = window.URL.createObjectURL(docfile);
                    link.href = file.StorageUri.PrimaryUri
                    link.download = docfile.name
                    document.body.appendChild(link)
                    link.click()
                    document.body.removeChild(link)
                })
        },
        add_item() {

            this.add_folder(this.folder.id_item, this.folder.name_item, this.folder.file[0])



        },
        delete_single_Item(item) {

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

                    axios.delete(window.laravel.url + '/delete_folder/' + item.id)
                        .then(response => {

                        })
                        .catch(error => {
                            console.log(error);
                        })

                    const index = this.reponse_items.indexOf(item);

                    this.reponse_items.splice(index, 1);
                    

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
        update_folder: function(item_object) {



            axios.put(window.laravel.url + '/update_folder', item_object)
                .then(response => {
                    console.log(response.data);

                })
                .catch(error => {
                    console.log(error);
                })

        },
        changeState() {

            if (this.checked == "file") {
                this.show_input_file = true;
                this.show_text_folder = false;
            } else if (this.checked == "folder") {
                this.show_input_file = false;
                this.show_text_folder = true;
            }

        },
        save() {

            if (this.editedIndex > -1) {
                Object.assign(this.reponse_items[this.editedIndex], this.editedItem)
                this.update_folder(this.editedItem)

            } else {
                this.reponse_items.push(this.editedItem)
            }

            this.close()

        },

        close() {

            this.dialog = false
            this.$nextTick(() => {
                this.editedItem = Object.assign({}, this.defaultItem)
                this.editedIndex = -1

            })
            this.expanded = [];

        },


        editItem(item) {

            this.editedIndex = this.reponse_items.indexOf(item)
            this.editedItem = Object.assign({}, item)
            this.dialog = true

        },




        add_folder: function(id, name, file) {
            let jsonData = new FormData()
            jsonData.append('id_parent', id)
            jsonData.append('name', name)

            if (file) {
                jsonData.append("file", file, file.name)
            }

            axios.post(window.laravel.url + '/add_folder', jsonData)
                .then(response => {
                    console.log(response.data);

                    if (response.data.etat) {

                        const Toast = Swal.mixin({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 2000,
                            timerProgressBar: true,
                            onOpen: (toast) => {
                                toast.addEventListener('mouseenter', Swal.stopTimer)
                                toast.addEventListener('mouseleave', Swal.resumeTimer)
                            }
                        })

                        Toast.fire({
                            icon: 'success',
                            title: 'Ajouté avec succes'
                        })


                      
                        this.array_item.unshift(this.folder);
                        this.reponse_items.unshift(this.folder);
                        this.folder.id_item = null;
                        this.folder.name_item = '';

                        this.folder.file = [];


                        this.get_data();


                    }


                })
        },
        get_data: function() {

            axios.get(window.laravel.url + '/get_folders_items')
                .then(response => {

                    const treeify = (arr, pid) => {
                        const tree = [];
                        const lookup = {};
                        // Initialize lookup table with each array item's id as key and 
                        // its children initialized to an empty array 
                        arr.forEach((o) => {
                            lookup[o.id] = o;
                            lookup[o.id].children = [];
                        });
                        arr.forEach((o) => {
                            // If the item has a parent we do following:
                            // 1. access it in constant time now that we have a lookup table
                            // 2. since children is preconfigured, we simply push the item
                            if (o.parentId !== null) {
                                lookup[o.parentId].children.push(o);
                            } else {
                                // no o.parent so this is a "root at the top level of our tree
                                tree.push(o);
                            }
                        });
                        return tree;
                    };

                    this.array_item = response.data.item_folder_label;

                    var covert_hierarchie_items_label = treeify(this.array_item);
                    this.items_label = covert_hierarchie_items_label;

                    this.reponse_items = response.data.item_folder;

                    var covert_hierarchie_items = treeify(this.reponse_items);
                    this.items = covert_hierarchie_items;



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