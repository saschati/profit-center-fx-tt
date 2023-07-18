import { StockQuotesStatistic } from '@/types/model/stockQuotes'
import { createSlice } from '@reduxjs/toolkit'
import { stockQuotesApi } from '../services/injects/stockQuotes'

type StockQuotesState = {
  stockQuotesStatistics: StockQuotesStatistic[]
}

const initialState: StockQuotesState = {
  stockQuotesStatistics: [],
}

const slice = createSlice({
  name: 'stockQuotes',
  initialState,
  reducers: {},
  extraReducers: (builder) => {
    // POST Statistic
    builder.addMatcher(stockQuotesApi.endpoints.saveStatistics.matchFulfilled, (state, action) => {
      state.stockQuotesStatistics = [action.payload.data, ...state.stockQuotesStatistics]
    })

    // GET Statistic
    builder.addMatcher(stockQuotesApi.endpoints.getStatistics.matchFulfilled, (state, action) => {
      state.stockQuotesStatistics = [...state.stockQuotesStatistics, ...action.payload.data]
    })
  },
})

export default slice.reducer
