import { SummaryStatisticData } from '@/types/model/stockQuotes'
import { StatisticStockQuotesManager } from './statisticManger'

export type SendStatistic<T> = (statistic: SummaryStatisticData, data: T) => void

const collectStatistic = <T>(sender: SendStatistic<T>) => {
  const manger = new StatisticStockQuotesManager()
  let currTotal = 0

  return (value: number, total: number, data: T) => {
    manger.setValue(value)

    currTotal++
    if (currTotal >= total) {
      currTotal = 0
      const clone = manger.clone()
      void new Promise((resolve) => {
        const statistic = clone.getSummaryStatisticData()

        sender({ ...statistic }, data)

        resolve(true)
      })
    }
  }
}

export default collectStatistic
