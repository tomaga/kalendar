function updateCurrentDates(){
    const today = new Date();

    let date = today.getDate();
    let day = today.getDay();
    let month = today.getMonth();
    let year = today.getFullYear();

    data.current_date.day = day;
    data.current_date.month = month;
    data.current_date.year = year;
    data.current_date.date = date;

    data.calendar.month = month;
    data.calendar.year = year;

    document.getElementById("cur-year").innerHTML = year;
    document.getElementById("cur-day").innerHTML = translateToWeekdayName(day);
    document.getElementById("cur-date").innerHTML = addOrdinalIndicator(date);
    document.getElementById("cur-month").innerHTML = translateToMonthName(month);
}

function updateCalendarDates(){
    document.getElementById("cal-year").innerHTML = data.calendar.year;
    document.getElementById("cal-month").innerHTML = translateToMonthName(data.calendar.month);
}

function addOrdinalIndicator(date){
    switch(date){
        case 1:
        case 21:
        case 31: return date + "<sup>ní</sup>";
        case 2:
        case 22: return date + "<sup>hý</sup>";
        case 3:
        case 23: return date + "<sup>tí</sup>";
        default: return date + "<sup>tý</sup>";
    }
}

function translateToWeekdayName(day){
    switch(day){
        case 0: return "Neděle";
        case 1: return "Pondělí";
        case 2: return "Úterý";
        case 3: return "Středa";
        case 4: return "Čtvrtek";
        case 5: return "Pátek";
        case 6: return "Sobota";
    }
}

function translateToMonthName(month){
    switch(month){
        case 0: return "Leden";
        case 1: return "Únor";
        case 2: return "Březen";
        case 3: return "Duben";
        case 4: return "Květen";
        case 5: return "Červen";
        case 6: return "Červenec";
        case 7: return "Srpen";
        case 8: return "Září";
        case 9: return "Říjen";
        case 10: return "Lictopad";
        case 11: return "Prosinec";
    }
}