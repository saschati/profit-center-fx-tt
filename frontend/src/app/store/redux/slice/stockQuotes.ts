import { StockQuotesStatistic } from '@/types/model/stockQuotes'
import { createSlice } from '@reduxjs/toolkit'
import { stockQuotesApi } from '../services/injects/stockQuotes'
import { MetaPagginate } from '@/types/response'

type StockQuotesState = {
  stockQuotesStatistics: StockQuotesStatistic[]
  stockQuotesStatisticsCurrentMeta: MetaPagginate | null
  lessCreateAt: string | null
}

const initialState: StockQuotesState = {
  stockQuotesStatistics: [],
  stockQuotesStatisticsCurrentMeta: null,
  lessCreateAt: null,
}

const slice = createSlice({
  name: 'stockQuotes',
  initialState,
  reducers: {},
  extraReducers: (builder) => {
    // POST Statistic
    builder.addMatcher(stockQuotesApi.endpoints.stockQuotesSaveStatistics.matchFulfilled, (state, action) => {
      state.stockQuotesStatistics = [action.payload.data, ...state.stockQuotesStatistics]
    })

    // GET Statistic
    builder.addMatcher(stockQuotesApi.endpoints.stockQuotesGetStatistics.matchFulfilled, (state, action) => {
      if (state.lessCreateAt === null && action.payload.data.length !== 0) {
        const item = action.payload.data[0]

        state.lessCreateAt = item.createdAt
      }

      state.stockQuotesStatistics = [...state.stockQuotesStatistics, ...action.payload.data]
      state.stockQuotesStatisticsCurrentMeta = action.payload.meta
    })
  },
})

export default slice.reducer
