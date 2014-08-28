function push(context, data)
{
    $.ajax({
        url: '/api/push/' + context,
        type: 'PUT',
        dataType: 'json',
        data: JSON.stringify({
                "user": {
                    "name": $('#doctorName').val(),
                    "email": $('#doctorEmail').val()
                },
                "data": data
        })
    }).done(function(data) {
        $('#console').html(JSON.stringify(data));
    });
}

$(document).ready(function() {

    $('#doctorPrescribing').click(function(e) {
        push('personal_health_medical_prescriptions', {
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
        });
    });

    $('#medicalHistory1').click(function(e) {
        push('personal_health_medical', {
            "dateAndTime":"1988-04-04 13:37:00 UTC-1",
            "description":"Douglas was born",
            "relatedWith":
                [
                    {
                        "name":"Bob",
                        "number":239878347,
                        "email":"bob@doctors.org",
                        "signature":"e4eaaaf2-d142-11e1-b3e4-080027620cdd"
                    }
                ]
        });
    });

    $('#medicalHistory2').click(function(e) {
        push('personal_health_medical', {
            "dateAndTime":"2014-07-22 08:14:47 UTC-1",
            "description":"Visit to G.P.",
            "relatedWith":
                [
                    {
                        "name":"Bob",
                        "number":239878347,
                        "email":"bob@doctors.org",
                        "signature":"e4eaaaf2-d142-11e1-b3e4-080027620cdd"
                    }
                ]
        });
    });

    $('#medicalHistory3').click(function(e) {
        push('personal_health_medical', {
            "dateAndTime":"2014-08-26 16:45:22 UTC-1",
            "description":"Visit to G.P.",
            "relatedWith":
                [
                    {
                        "name":"Bob",
                        "number":239878347,
                        "email":"bob@doctors.org",
                        "signature":"e4eaaaf2-d142-11e1-b3e4-080027620cdd"
                    }
                ]
        });
    });

    $('#medicalHistory4').click(function(e) {
        push('personal_health_medical', {
            "dateAndTime":"2014-08-26 16:45:22 UTC-1",
            "description":"Referral to specialist",
            "relatedWith":
                [
                    {
                        "name":"Wilma",
                        "number":39845897,
                        "email":"wilma@doctors.org",
                        "signature":"11a38b9a-b3da-360f-9353-a5a725514269"
                    }
                ]
        });
    });


});