import React, {Component} from 'react';
import ExchangeRatesItem from "./ExchangeRatesItem";

class ExchangeRatesList extends Component {

    render() {

        return (
            <div>
                <table className="table" id="exchange_rates_table">
                    <thead>
                    <tr>
                        <th scope="col">Code</th>
                        <th scope="col">Currency</th>
                        <th scope="col">NBP</th>
                        <th scope="col">Buy</th>
                        <th scope="col">Sell</th>
                    </tr>
                    </thead>
                    <tbody>
                    {this.props.exchangeRates.map((exchangeRate, index) => {
                        return <ExchangeRatesItem exchangeRate={exchangeRate} key={index} />
                    })}
                    </tbody>
                </table>
            </div>
        );
    }
}

export default ExchangeRatesList;