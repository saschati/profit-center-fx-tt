import { StockQuotesStatistic } from '@/types/model/stockQuotes'
import { api } from '../api'
import { MetaPagginate } from '@/types/response'

interface StockQuotesStatisticPostResponse {
  data: StockQuotesStatistic
}

interface GetStockQuotesStatisticsResponse {
  data: StockQuotesStatistic[]
  meta: MetaPagginate
}

interface GetStockQuotesStatisticsQuery {
  page: number
  lessCreateAt?: string | null
}

export type StockQuotesStatisticPost = Omit<StockQuotesStatistic, 'id' | 'createdAt'>

export const stockQuotesApi = api.injectEndpoints({
  endpoints: (build) => ({
    stockQuotesGetStatistics: build.query<GetStockQuotesStatisticsResponse, GetStockQuotesStatisticsQuery>({
      query: ({ lessCreateAt = null, page = 1 }) => ({
        url: 'stock-quotes/statistics',
        params: {
          lessCreateAt: lessCreateAt || undefined,
          page,
        },
      }),
      providesTags: ['StockQuotes'],
    }),
    stockQuotesSaveStatistics: build.mutation<StockQuotesStatisticPostResponse, StockQuotesStatisticPost>({
      query: (data) => ({
        url: 'stock-quotes/statistics/save',
        method: 'POST',
        body: data,
      }),
    }),
  }),
})

export const {
  useStockQuotesSaveStatisticsMutation,
  useStockQuotesGetStatisticsQuery,
  useLazyStockQuotesGetStatisticsQuery,
} = stockQuotesApi
