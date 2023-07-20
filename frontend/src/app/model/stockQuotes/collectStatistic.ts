import { SummaryStatisticData } from '@/types/model/stockQuotes'
import { StatisticStockQuotesManager } from './statisticManger'

export interface CollectSummaryStatisticData extends SummaryStatisticData {
  startDate: Date
  endDate: Date
}

export type SendStatistic<T> = (statistic: CollectSummaryStatisticData, data: T) => void

const collectStatistic = <T>(sender: SendStatistic<T>) => {
  let manger = new StatisticStockQuotesManager()
  let currTotal = 0
  let startDate: null | Date = null

  return (value: number, total: number, data: T) => {
    if (startDate === null) {
      startDate = new Date()
    }

    manger.setValue(value)

    currTotal++
    if (currTotal >= total) {
      const cloneStartDate = new Date(startDate.getTime())
      const clone = manger.clone()

      manger = new StatisticStockQuotesManager()

      void new Promise((resolve) => {
        const statistic = clone.getSummaryStatisticData()
        const endDate = new Date()

        sender({ ...statistic, startDate: cloneStartDate, endDate }, data)

        resolve(true)
      })

      currTotal = 0
      startDate = null
    }
  }
}

export default collectStatistic
