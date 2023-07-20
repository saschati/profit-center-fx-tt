export interface SummaryStatisticData {
  average: number
  max: number
  min: number
  standardDeviation: number
  mode: number
}

export interface StockQuotesStatistic extends SummaryStatisticData {
  id: string
  sessionId: string
  startDate: string
  endDate: string
  createdAt: string
}
