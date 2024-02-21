const CORE = {
    csrfToken: document.querySelector(`[name="csrf-token"]`).content,
    baseUrl: window.location.origin,
    listRegion: [],

    dayInd(day) {
        let dayInd = "";

        switch (day) {
            case "Monday":
                dayInd = "Senin";
                break;
            case "Tuesday":
                dayInd = "Selasa";
                break;
            case "Wednesday":
                dayInd = "Rabu";
                break;
            case "Thursday":
                dayInd = "Kamis";
                break;
            case "Friday":
                dayInd = "Jum'at";
                break;
            case "Saturday":
                dayInd = "Sabtu";
                break;
            case "Sunday":
                dayInd = "Minggu";
                break;
        }

        return dayInd;
    },

    numberFormat(value) {
        if (value.toString()[0] == "-") {
            var negative = "-";
        } else {
            negative = "";
        }
        var raw = value
            .toString()
            .replace(/(?!\.)\D/g, "")
            .split(".");
        var whole = raw[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        var decimal = false;
        if (raw.length > 1) {
            decimal = raw[1];
        }
        if (decimal !== false && (decimal !== "0" || decimal !== "00")) {
            return negative + whole + "," + decimal;
        } else {
            return negative + whole;
        }
    },

    bindNumberFormat: function () {
        let listInputNumber = document.querySelectorAll(".number-format");
        for (let i = 0; i < listInputNumber.length; i++) {
            listInputNumber[i].addEventListener("keyup", function (e) {
                if (e.keyCode !== 6 && e.keyCode !== 46) {
                    this.value = CORE.numberFormat(this.value);
                }
            });
        }
    },

    init() {
        CORE.initSubmitCrud();
        CORE.initSearchRegion();
        CORE.bindNumberFormat();
    },

    sweet(icon, title, text) {
        Swal.fire({
            icon: icon,
            title: title,
            text: text,
        });
    },

    delay(fn, ms) {
        let timer;
        return function (...args) {
            clearTimeout(timer);
            timer = window.setTimeout(fn.bind(this, ...args), ms || 0);
        };
    },

    initSearchRegion() {
        CORE.listRegion = [];
        const inputRegion = document.querySelector(`[name="region_name"]`);

        if (inputRegion) {
            inputRegion.addEventListener(
                "keyup",
                CORE.delay(function () {
                    if (inputRegion.value != "") {
                        fetch(
                            `${CORE.baseUrl}/app/regions/search?q=${inputRegion.value}`,
                            {
                                method: "POST",
                                headers: {
                                    "X-CSRF-TOKEN": CORE.csrfToken,
                                },
                            }
                        )
                            .then((response) => response.json())
                            .then((response) => {
                                const template =
                                    document.querySelector(`#listRegionSearch`);
                                let html = "";

                                if (response.status) {
                                    CORE.listRegion = response.data;

                                    response.data.forEach((region) => {
                                        html += `<p onclick="CORE.choiceRegion('${region.region_id}')">${region.subdistrict}, ${region.district}, ${region.province}</p>`;
                                    });
                                } else {
                                    html += `<p>Daerah tidak ditemukan!</p>`;
                                }

                                template.classList.remove("d-none");
                                template.innerHTML = html;
                            });
                    }
                }, 1500)
            );

            inputRegion.addEventListener(
                "blur",
                CORE.delay(function () {
                    const template =
                        document.querySelector(`#listRegionSearch`);
                    template.classList.add("d-none");
                }, 700)
            );
        }
    },

    choiceRegion(regionID) {
        const findRegion = CORE.listRegion.find(
            (region) => region.region_id == regionID
        );
        const inputName = document.querySelector(`[name="region_name"]`);
        const inputID = document.querySelector(`[name="region_id"]`);

        if (findRegion) {
            const regionName = `${findRegion.subdistrict}, ${findRegion.district}, ${findRegion.province}`;

            inputName.value = regionName;
            inputID.value = regionID;
        }
    },

    showLoadAdmin() {
        const loader = document.querySelector(".parent-loader");
        if (loader) {
            loader.classList.remove("d-none");
        }
    },

    removeLoadAdmin() {
        const loader = document.querySelector(".parent-loader");
        if (loader) {
            loader.classList.add("d-none");
        }
    },

    initSubmitCrud() {
        const forms = document.querySelectorAll(`form[with-submit-crud]`);

        forms.forEach((form) => {
            form.addEventListener("submit", function (e) {
                e.preventDefault();
                CORE.showLoadAdmin();
                CORE.submitFormCrud(this);
            });
        });
    },

    promptUser(message, callback) {
        Swal.fire({
            title: "Anda yakin?",
            text: message,
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Ya, lakukan ini!",
        }).then((result) => {
            if (result.value) {
                callback();
            }
        });
    },

    promptForm(formId, message) {
        Swal.fire({
            title: "Anda yakin?",
            text: message,
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Ya, lakukan ini!",
        }).then((result) => {
            if (result.value) {
                const form = document.querySelector(`#${formId}`);

                if (form.getAttribute("with-submit-crud") !== null) {
                    CORE.showLoadAdmin();
                    CORE.submitFormCrud(form);
                } else {
                    form.submit();
                }
            }
        });
    },

    promptDeleteFetch(formId, message) {
        Swal.fire({
            title: "Anda yakin?",
            text: message,
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Ya, lakukan ini!",
        }).then((result) => {
            if (result.value) {
                CORE.showLoadAdmin();

                const form = document.querySelector(`#${formId}`);
                const fulUrl = form.action;

                fetch(fulUrl, {
                    method: "DELETE",
                    headers: {
                        "X-CSRF-TOKEN": CORE.csrfToken,
                        "Content-Type": "application/json",
                    },
                })
                    .then((response) => response.json())
                    .then((response) => {
                        CORE.removeLoadAdmin();
                        CORE.sweet("success", "Berhasil!", response.message);
                        window.setTimeout(
                            () => (window.location.href = response.next_url),
                            700
                        );
                    })
                    .catch((err) => {
                        CORE.removeLoadAdmin();
                        CORE.sweet(
                            "error",
                            "Gagal!",
                            "Terjadi kesalahan server!"
                        );
                    });
            }
        });
    },

    async submitFormCrud(form) {
        const url = form.action;
        const method = form.method;

        let options = {};
        if (method == "post") {
            options = {
                headers: {
                    "X-CSRF-TOKEN": CORE.csrfToken,
                    // "Content-Type": "application/json",
                    "Accept": "application/json"
                },
                method: "POST",
                body: new FormData(form),
            };
        }

        const request = await fetch(url, options);

        CORE.removeLoadAdmin();

        if (request.status == 200) {
            const response = await request.json();
            CORE.sweet("success", "Sukses!", response.message);
            window.setTimeout(
                () => (window.location.href = response.next_url),
                1500
            );
        } else if (request.status == 400) {
            const response = await request.json();
            CORE.sweet("error", "Gagal!", "Terdapat input yang salah!");
            CORE.insertValidationErrors(response.data);
        } else if (request.status == 422) {
            const response = await request.json();
            CORE.sweet("error", "Gagal!", "Terdapat input yang salah!");
            CORE.insertValidationErrorsNew(response.errors);
        } else {
            const response = await request.json();
            CORE.sweet("error", "Gagal!", response.message);
        }
    },

    submitForm(formID, callback) {
        const form = document.querySelector(`#${formID}`);
        const url = form.action;
        const method = form.method;

        let options = {};
        if (method == "post") {
            options = {
                headers: {
                    "X-CSRF-TOKEN": CORE.csrfToken,
                    "Conten-Type": "application/json",
                },
                method: "POST",
                body: new FormData(form),
            };
        }

        fetch(url, options)
            .then((response) => response.json())
            .then((response) => {
                callback(response);
            });
    },

    insertValidationErrors(data) {
        const listInput = document.querySelectorAll("form[with-submit-crud] .form-control");
        // console.log(listInput);
        const listNameError = Object.keys(data);

        listInput.forEach((input) => {
            let inputName = input.name;
            let findInput = listNameError.find((d) => d == inputName);

            if (findInput) {
                input.classList.add("is-invalid");
                input.nextElementSibling.innerHTML = `<small class="text-danger">${data[findInput][0]}</small>`;
            } else {
                // console.log(input);
                input.nextElementSibling.innerHTML = ``;
                input.classList.remove("is-invalid");
            }
        });
    },

    insertValidationErrorsNew(data) {
        console.log(data);
        const listInput = document.querySelectorAll(
            "form[with-submit-crud] .form-control"
        );
        // console.log(listInput);
        const listNameError = Object.keys(data);

        listInput.forEach((input) => {
            let validationID = "";
            if (input.hasAttribute("data-validation-id")) {
                validationID = input.getAttribute("data-validation-id");
            }
            let inputName = input.name;
            let findInput = listNameError.find((d) => d == inputName || d == validationID);

            if (findInput) {
                input.classList.add("is-invalid");
                input.nextElementSibling.innerHTML = `<small class="text-danger">${data[findInput][0]}</small>`;
            } else {
                // console.log(input);
                input.nextElementSibling.innerHTML = ``;
                input.classList.remove("is-invalid");
            }
        });
    },

    submitLogin() {
        CORE.submitForm("formLogin", function (response) {
            // console.log(response);

            if (response.status_code == 200) {
                CORE.sweet("success", "Sukses!", "Berhasil login!");
                window.setTimeout(
                    () => (window.location.href = response.next_url),
                    1500
                );
            } else if (response.status_code == 400) {
                CORE.insertValidationErrors(response.data);
            } else {
                CORE.sweet("error", "Gagal!", response.message);
            }
        });
    },

    dataTableServer: function (
        tableId,
        link,
        dataObject = false,
        searching = true,
        emptyText = false
    ) {
        let text =
            emptyText != false ? emptyText : "No data available in table";
        if (dataObject == false) {
            dataObject = {
                _token: CORE.csrfToken,
            };
        } else {
            dataObject._token = CORE.tokenCsrf;
        }

        let dataTable = $(`#${tableId}`).DataTable({
            // "responsive": true,
            searching: searching,
            processing: true,
            serverSide: true,
            order: [],
            ajax: {
                url: `${CORE.baseUrl}${link}`,
                type: "POST",
                data: dataObject,
            },
            language: {
                emptyTable: text,
            },
            columnDefs: [
                {
                    targets: [0],
                    orderable: false,
                },
            ],
            initComplete: function (settings, json) {
                CORE.initSubmitCrud();
            },
        });

        return dataTable;
    },

    dataTableCostum: function (
        tableId,
        link,
        dataObject = false,
        searching = false,
        emptyText = false
    ) {
        let text =
            emptyText != false ? emptyText : "No data available in table";
        if (dataObject == false) {
            dataObject = {
                _token: CORE.csrfToken,
            };
        } else {
            dataObject._token = CORE.tokenCsrf;
        }

        let dataTable = $(`#${tableId}`).DataTable({
            // "responsive": true,
            searching: searching,
            processing: true,
            serverSide: true,
            order: [],
            ajax: {
                url: `${CORE.baseUrl}${link}`,
                type: "POST",
                data: dataObject,
            },
            language: {
                emptyTable: text,
            },
            columnDefs: [
                {
                    targets: [0],
                    orderable: false,
                },
            ],
            initComplete: function (settings, json) {
                CORE.initSubmitCrud();
            },
        });

        return dataTable;
    },

    showModal(modalId) {
        let showModal = new bootstrap.Modal(document.getElementById(modalId));
        showModal.show();
    },

    closeModal(modalId) {
        let showModal = bootstrap.Modal.getInstance(
            document.getElementById(modalId)
        );
        showModal.hide();
    },

    closeAllModal() {
        let modal = document.querySelectorAll(".modal");
        modal.forEach((item) => {
            let showModal = bootstrap.Modal.getInstance(item);
            showModal.hide();
        });
    },

    randomString(length = 7) {
        var result = "";
        var characters =
            "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
        var charactersLength = characters.length;
        for (var i = 0; i < length; i++) {
            result += characters.charAt(
                Math.floor(Math.random() * charactersLength)
            );
        }
        return result;
    },
};

CORE.init();
