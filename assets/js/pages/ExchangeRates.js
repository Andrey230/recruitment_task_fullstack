import React, {Component} from 'react';
import axios from 'axios';
import ExchangeRatesList from "../components/ExchangeRatesList/ExchangeRatesList";
import ExchangeRatesInput from "../components/ExchangeRatesInput/ExchangeRatesInput";

class ExchangeRates extends Component {

    static baseUrl = 'http://telemedi-zadanie.localhost';
    static minDate = '2023-01-01';
    static maxDate = new Date().toISOString().split('T')[0];

    constructor() {
        super();

        const urlParams = new URLSearchParams(window.location.search);
        const dateParam = urlParams.get('date');
        const initialDate = this.isValidDate(dateParam) ? dateParam : ExchangeRates.maxDate;

        this.state = {
            exchangeRates: [],
            exchangeDate: initialDate
        };
    }

    isValidDate(date) {
        if (!date) return false;

        const dateRegex = /^\d{4}-\d{2}-\d{2}$/;
        if (!dateRegex.test(date)) return false;

        return date >= ExchangeRates.minDate && date <= ExchangeRates.maxDate;
    }

    componentDidMount() {
        this.getExchangeRates();
    }

    getExchangeRates() {
        axios.get(ExchangeRates.baseUrl + `/api/exchange-rates/${this.state.exchangeDate}`).then(response => {
            this.setState({
                exchangeRates: response.data,
            })
        }).catch((error) => {
            this.setState({ exchangeRates: []});
        });
    }

    handleDateChange = (newDate) => {
        this.setState({ exchangeDate: newDate }, () => {
            const url = new URL(window.location);
            url.searchParams.set('date', newDate);
            window.history.replaceState(null, '', url);
            this.getExchangeRates();
        });
    }

    render() {
        return (
            <div className="container mt-5">
                <ExchangeRatesInput
                    selectedDate={this.state.exchangeDate}
                    onDateChange={this.handleDateChange}
                    minDate={ExchangeRates.minDate}
                    maxDate={ExchangeRates.maxDate}
                />

                {this.state.exchangeRates.length > 0
                    ? <ExchangeRatesList exchangeRates={this.state.exchangeRates} />
                    : <p>Exchange rates are not available for the selected date. Please try choosing a different date.</p>

                }
            </div>
        );
    }
}

export default ExchangeRates;