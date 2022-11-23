$(document).ready(() => {

    ajaxCall("GET", "../php/admin.php", { get_users: true }, "Couldn't load users")
        .then(buildUsersTable)
        .catch(alertError)

})

const buildUsersTable = (fetcheddata) => {
    data = JSON.parse(fetcheddata)
    console.log(data)
    var table = $("#usersTable").DataTable({
        data: data,
        columns: [
            { data: 'ID' },
            { data: 'NAME' },
            { data: 'SURNAME' },
            { data: 'EMAIL' },
            { data: 'ROLE' },
            {
                data: 'CONFIRMED',
                render: (data, type, row, meta) => {
                    var disabled = "";
                    if (data == "1") { // Check if user is confirmed
                        disabled = "disabled" // set button as disabled
                    }
                    return "<button id=\"" + row['ID'] + "\"class=\"confirm\" " + disabled + ">Confirm</button>"

                }
            },
        ]
    })

    $('.confirm').click((event) => {
        confirmedId = $(event.target).attr('id')
        $(event.target).prop('disabled', true)
        updateConfirmed(confirmedId);
    })
}

const updateConfirmed = (id) => {
    //ajax to update db and fetch new data and rerender datatables
    ajaxCall("POST", "../php/confirmUser.php", {id: id}, "Couldn't confirm user")
    .then((response) => alert(response))
    .catch(alertError)

}

const fetchSampleData = (errordata = null) => {
    return new Promise((respond, reject) => {
        if (errordata) { reject(errordata) }
        respond(SAMPLE_DATA)
    })
}

const ajaxCall = (requestType, requestURL, requestData, errorMessage) => {
    return new Promise((respond, reject) => {
        $.ajax({
            type: requestType,
            url: requestURL,
            data: requestData,
            success: (response) => respond(response),
            error: (response) => reject(errorMessage, response)
        })
    })
}

const buildUsersList = (data) => {
    // var data = JSON.parse(data)
    console.log(JSON.parse(data))

}

const alertError = (message, response) => {
    console.log(response)
    alert(message)
}

SAMPLE_DATA = [
    {
        id: 1,
        name: "anta",
        surname: "mouz",
        email: "sfsdf@ibibi.sf",
        role: "ADMIN",
        confirmed: true
    },
    {
        id: 2,
        name: "pan",
        surname: "sav",
        email: "sfsdf@ibibi.sf",
        role: "USER",
        confirmed: true
    },
    {
        id: 3,
        name: "tati",
        surname: "sisi",
        email: "sfsdf@ibibi.sf",
        role: "PRODUCTSELLER",
        confirmed: false
    }
]