BEGIN:VCALENDAR<br>
PRODID:-//crm.nedicom.ru<br>
VERSION:2.0<br>
X-WR-TIMEZONE:Europe/Moscow<br>
CALSCALE:GREGORIAN<br>
@foreach($data as $el)
    BEGIN:VEVENT<br>
    SUMMARY:{{ Str::limit($el->name, 50) }}<br>
    DTSTART;TZID=Europe/Moscow:@php    
    $datetime = new DateTime($el->date['value']);
    echo date_format($datetime,"Ymd");
    echo "T";
    echo date_format($datetime,"His");
    @endphp<br>
    DTEND;TZID=Europe/Moscow    :@php   
    $oldDate = date('Y-m-d H:i:s', strtotime($el->date['value']. ' + 30 minutes'));
    $datetime2 = new DateTime($oldDate);
    echo date_format($datetime2,"Ymd");
    echo "T";
    echo date_format($datetime2,"His");
    @endphp<br>
    UID:{{$el -> id}}.crm.nedicom.ru
    LOCATION:Crimea<br>
    DESCRIPTION: {{ Str::limit($el->description, 50) }}<br>
    STATUS:CONFIRMED<br>
    SEQUENCE:0<br>
    URL:https://crm.nedicom.ru/tasks/{{$el -> id}}<br>
    TRANSP:OPAQUE
    CATEGORIES:nacategory
    END:VALARM<br>
    END:VEVENT<br>
@endforeach
END:VCALENDAR<br>