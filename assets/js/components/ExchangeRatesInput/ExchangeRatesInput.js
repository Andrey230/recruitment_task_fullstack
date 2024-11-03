import React, {Component} from 'react';

class ExchangeRatesInput extends Component {

    handleDateChange = (event) => {
        const newDate = event.target.value;
        this.props.onDateChange(newDate);
    }

    render() {
        return (
            <div className="input-group mb-3 w-25">
                <input
                    type="date"
                    className="form-control"
                    placeholder="Date"
                    aria-label="Date"
                    aria-describedby="basic-addon1"
                    value={this.props.selectedDate}
                    onChange={this.handleDateChange}
                    min={this.props.minDate}
                    max={this.props.maxDate}
                />
            </div>
        );
    }
}

export default ExchangeRatesInput;