import { StockQuotesStatistic } from '@/types/model/stockQuotes'
import { api } from '../api'
import { MetaPagginate } from '@/types/response'

interface StockQuotesStatisticPostResponse {
  data: StockQuotesStatistic
}

interface StockQuotesStatisticsResponse {
  data: StockQuotesStatistic[]
  meta: MetaPagginate
}

export type StockQuotesStatisticPost = Omit<StockQuotesStatistic, 'id'>

export const stockQuotesApi = api.injectEndpoints({
  endpoints: (build) => ({
    getStatistics: build.query<StockQuotesStatisticsResponse, void>({
      query: () => ({ url: 'stock-quotes/statistics' }),
      providesTags: ['StockQuotes'],
    }),
    saveStatistics: build.mutation<StockQuotesStatisticPostResponse, StockQuotesStatisticPost>({
      query: (data) => ({
        url: 'stock-quotes/statistics',
        method: 'POST',
        body: data,
      }),
    }),
  }),
})

export const { useSaveStatisticsMutation, useGetStatisticsQuery } = stockQuotesApi
