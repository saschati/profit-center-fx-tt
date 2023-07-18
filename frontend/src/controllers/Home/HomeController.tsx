import StockQuotes from '@/Domain/StockQuotes/StockQuotes'
import React from 'react'

const HomeController: React.FC = (): JSX.Element => {
  return (
    <div>
      <StockQuotes />
    </div>
  )
}

export default HomeController
