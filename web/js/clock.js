function Clock() {
    this.date = new Date();
    this.clocksize=12;
}

Clock.prototype.date = null;
Clock.prototype.clocksize = 24; //12 or 24


Clock.prototype.getTime = function () {
    hours = this.date.getHours();
    minutes = this.date.getMinutes();

    if(this.clocksize == 12 && hours > 12){
        hours = hours-12;
    }

    if(hours < 10){
        hours = '0'+hours;
    }

    if(minutes < 10){
        minutes = '0'+minutes;
    }

    return hours+":"+minutes;
};

