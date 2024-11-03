import React, {Component} from 'react';

class ExchangeRatesItem extends Component {
    render() {
        const exchangeRate = this.props.exchangeRate;

        return (
            <tr>
                <td>{exchangeRate.currencyCode}</td>
                <td>{exchangeRate.currencyName}</td>
                <td>{exchangeRate.nbpRate.toFixed(2)}</td>
                <td>{exchangeRate.buyRate !== null ? exchangeRate.buyRate.toFixed(2) : '-'}</td>
                <td>{exchangeRate.sellRate.toFixed(2)}</td>
            </tr>
        );
    }
}

export default ExchangeRatesItem;