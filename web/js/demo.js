var pushRequest = {
    "user": {
        "name": "Bob",
        "email": "bob@doctors.org"
    },
    "data": {
        "prescriptionNumber": 12345,
        "dateAndTime": "2014-08-26 16:45:22 UTC-1",
        "prescribingMedic": {
            "name": "Bob",
            "number": 239878347,
            "email": "bob@doctors.org",
            "signature": "e4eaaaf2-d142-11e1-b3e4-080027620cdd"
        },
        "items": [
            {
                "name": "Valium",
                "dosage": "1 pill",
                "frequency": "Daily",
                "instruction": "Don't operate heavy machinery"
            },
            {
                "name": "Prozac",
                "dosage": "1 pill",
                "frequency": "Twice a day",
                "instruction": "Don't operate heavy machinery"
            }
        ]
    }
};

$(document).ready(function() {

    $('#doctorPrescribing').click(function(e) {
        pushRequest.user.name = $('#doctorName').val();
        pushRequest.user.email = $('#doctorEmail').val();
        $.ajax({
            url: '/api/push/personal_health_medical_prescriptions',
            type: 'PUT',
            dataType: 'json',
            data: JSON.stringify(pushRequest)
        }).done(function(data) {
            console.log(data);
                $('#console').html(JSON.stringify(data));
        });
    });

});