import { useQuery } from "@tanstack/react-query";
import { fetchReports, fetchReport } from "@/lib/api";
import { useQueryClient } from "@tanstack/react-query";
import { createReport, updateReport } from "@/lib/api";
import { useMutation } from "@tanstack/react-query";
import { toast } from "sonner";
import { deleteReport } from "@/lib/api";

export function useReports() {
  const {
    data: reports,
    isPending,
    error,
    ...rest
  } = useQuery({
    queryKey: ["reports"],
    queryFn: fetchReports,
  });

  return {
    reports,
    isPending,
    error,
    ...rest,
  };
}

export function useReport(id: string) {
    const {
      data: report,
      isPending,
      error,
      ...rest
    } = useQuery({
      queryKey: ["report", id],
      queryFn: () => fetchReport(id),
    });
  
    return {
      report,
      isPending,
      error,
      ...rest,
    };
  }

export function useCreateReport() {
  const queryClient = useQueryClient();

  const mutation = useMutation({
    mutationFn: createReport,
    onSuccess: () => {
      queryClient.invalidateQueries({ queryKey: ["reports"] });
    },
    onError: () => {
        toast.error("Failed to create report.");
    },
  });

  return mutation;
}

export function useUpdateReport() {
  const queryClient = useQueryClient();

  const mutation = useMutation({
    mutationFn: updateReport,
    onSuccess: (_, { id }) => {
      queryClient.invalidateQueries({ queryKey: ["reports"] });
      queryClient.invalidateQueries({ queryKey: ["report", id] });
    },
    onError: () => {
      toast.error("Failed to update report.");
    },
  });

  return mutation;
}

export function useDeleteReport() {
  const queryClient = useQueryClient();

  const mutation = useMutation({
    mutationFn: deleteReport,
    onSuccess: () => {
      queryClient.invalidateQueries({ queryKey: ["reports"] });
      toast.success("Report deleted.");
    },
    onError: () => {
      toast.error("Failed to delete report.");
    },
  });

  return mutation;
}
